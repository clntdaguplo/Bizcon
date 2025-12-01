<?php

namespace App\Console\Commands;

use App\Models\Consultation;
use App\Models\ConsultationNotification;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendConsultationReminders extends Command
{
    protected $signature = 'consultations:send-reminders';
    protected $description = 'Send email and dashboard reminders for upcoming consultations (24h and 1h before)';

    public function handle()
    {
        $now = Carbon::now();
        $in24Hours = $now->copy()->addHours(24);
        $in1Hour = $now->copy()->addHours(1);
        
        // Find consultations scheduled in 24 hours (±30 minutes window)
        $consultations24h = Consultation::where('status', 'Accepted')
            ->whereNotNull('scheduled_date')
            ->whereNotNull('scheduled_time')
            ->whereDate('scheduled_date', $in24Hours->toDateString())
            ->get()
            ->filter(function($consultation) use ($in24Hours) {
                $scheduledDateTime = Carbon::parse($consultation->scheduled_date . ' ' . $consultation->scheduled_time);
                $diffInHours = $scheduledDateTime->diffInHours($in24Hours, false);
                return abs($diffInHours) <= 0.5; // Within 30 minutes
            });

        // Find consultations scheduled in 1 hour (±15 minutes window)
        $consultations1h = Consultation::where('status', 'Accepted')
            ->whereNotNull('scheduled_date')
            ->whereNotNull('scheduled_time')
            ->whereDate('scheduled_date', $in1Hour->toDateString())
            ->get()
            ->filter(function($consultation) use ($in1Hour) {
                $scheduledDateTime = Carbon::parse($consultation->scheduled_date . ' ' . $consultation->scheduled_time);
                $diffInHours = $scheduledDateTime->diffInHours($in1Hour, false);
                return abs($diffInHours) <= 0.25; // Within 15 minutes
            });

        $count24h = 0;
        $count1h = 0;

        // Send 24-hour reminders
        foreach ($consultations24h as $consultation) {
            // Check if reminder already sent
            $alreadySent = ConsultationNotification::where('consultation_id', $consultation->id)
                ->where('type', 'reminder_24h')
                ->exists();

            if (!$alreadySent) {
                $scheduledDateTime = Carbon::parse($consultation->scheduled_date . ' ' . $consultation->scheduled_time);
                
                // Notify customer
                $this->sendReminder($consultation, $consultation->customer_id, 'reminder_24h', 
                    'Consultation Reminder - 24 Hours',
                    "Your consultation '{$consultation->topic}' is scheduled for " . 
                    $scheduledDateTime->format('M j, Y g:i A') . 
                    ($consultation->meeting_link ? "\n\nMeeting Link: {$consultation->meeting_link}" : '')
                );

                // Notify consultant
                $consultantUserId = $consultation->consultantProfile->user_id;
                $this->sendReminder($consultation, $consultantUserId, 'reminder_24h',
                    'Consultation Reminder - 24 Hours',
                    "You have a consultation '{$consultation->topic}' scheduled for " . 
                    $scheduledDateTime->format('M j, Y g:i A') . 
                    ($consultation->meeting_link ? "\n\nMeeting Link: {$consultation->meeting_link}" : '')
                );

                $count24h++;
            }
        }

        // Send 1-hour reminders
        foreach ($consultations1h as $consultation) {
            // Check if reminder already sent
            $alreadySent = ConsultationNotification::where('consultation_id', $consultation->id)
                ->where('type', 'reminder_1h')
                ->exists();

            if (!$alreadySent) {
                $scheduledDateTime = Carbon::parse($consultation->scheduled_date . ' ' . $consultation->scheduled_time);
                
                // Notify customer
                $this->sendReminder($consultation, $consultation->customer_id, 'reminder_1h',
                    'Consultation Reminder - 1 Hour',
                    "Your consultation '{$consultation->topic}' starts in 1 hour at " . 
                    $scheduledDateTime->format('g:i A') . 
                    ($consultation->meeting_link ? "\n\nMeeting Link: {$consultation->meeting_link}" : '')
                );

                // Notify consultant
                $consultantUserId = $consultation->consultantProfile->user_id;
                $this->sendReminder($consultation, $consultantUserId, 'reminder_1h',
                    'Consultation Reminder - 1 Hour',
                    "Your consultation '{$consultation->topic}' starts in 1 hour at " . 
                    $scheduledDateTime->format('g:i A') . 
                    ($consultation->meeting_link ? "\n\nMeeting Link: {$consultation->meeting_link}" : '')
                );

                $count1h++;
            }
        }

        $this->info("Sent {$count24h} 24-hour reminders and {$count1h} 1-hour reminders.");
        return 0;
    }

    protected function sendReminder($consultation, $userId, $type, $title, $message)
    {
        // Create dashboard notification
        ConsultationNotification::create([
            'consultation_id' => $consultation->id,
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'sent_at' => now(),
        ]);

        // Send email notification (if user has email)
        $user = \App\Models\User::find($userId);
        if ($user && $user->email) {
            try {
                Mail::raw($message, function($mail) use ($user, $title) {
                    $mail->to($user->email)
                         ->subject($title . ' - BizConsult');
                });
            } catch (\Exception $e) {
                \Log::error("Failed to send email reminder: " . $e->getMessage());
            }
        }
    }
}

