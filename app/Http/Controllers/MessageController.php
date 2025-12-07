<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MessageController extends Controller
{
    /**
     * Send a message in a consultation conversation
     */
    public function store(Request $request, $consultationId)
    {
        // Always return JSON for AJAX requests
        $isAjax = $request->expectsJson() || $request->ajax() || $request->wantsJson();
        
        // Check if table exists
        if (!Schema::hasTable('consultation_messages')) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'error' => 'Messages table not found. Please run the migration: php artisan migrate'
                ], 500);
            }
            return back()->withErrors(['error' => 'Messages feature is not available. Please run the migration.']);
        }

        try {
            $validated = $request->validate([
                'message' => 'required|string|max:5000',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'error' => $e->getMessage() ?: 'Validation failed. Please check your message.'
                ], 422);
            }
            return back()->withErrors($e->errors());
        }

        try {
            $consultation = Consultation::findOrFail($consultationId);
        } catch (\Exception $e) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'error' => 'Consultation not found.'
                ], 404);
            }
            abort(404, 'Consultation not found.');
        }

        // Verify user has access to this consultation
        $user = Auth::user();
        $hasAccess = false;
        $senderType = null;

        if ($user->role === 'Customer' && $consultation->customer_id === $user->id) {
            $hasAccess = true;
            $senderType = 'customer';
        } elseif ($user->role === 'Consultant') {
            $consultantProfile = \App\Models\ConsultantProfile::where('user_id', $user->id)->first();
            if ($consultantProfile && $consultation->consultant_profile_id === $consultantProfile->id) {
                $hasAccess = true;
                $senderType = 'consultant';
            }
        }

        if (!$hasAccess) {
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'error' => 'You do not have access to this consultation.'
                ], 403);
            }
            abort(403, 'You do not have access to this consultation.');
        }

        try {
            $message = ConsultationMessage::create([
                'consultation_id' => $consultation->id,
                'sender_id' => $user->id,
                'sender_type' => $senderType,
                'message' => $request->message,
                'is_read' => false,
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to create consultation message', [
                'error' => $e->getMessage(),
                'consultation_id' => $consultation->id,
                'user_id' => $user->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($isAjax) {
                return response()->json([
                    'success' => false,
                    'error' => 'Failed to save message: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Failed to send message: ' . $e->getMessage()]);
        }

        // Mark other user's unread messages as read (if any)
        ConsultationMessage::where('consultation_id', $consultation->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        // Create notification for the recipient
        $recipientId = $senderType === 'customer' 
            ? $consultation->consultantProfile->user_id 
            : $consultation->customer_id;

        \App\Models\ConsultationNotification::create([
            'consultation_id' => $consultation->id,
            'user_id' => $recipientId,
            'type' => 'status_change',
            'title' => 'New Message',
            'message' => 'You have a new message in consultation: ' . $consultation->topic,
        ]);

        if ($isAjax) {
            return response()->json([
                'success' => true,
                'message' => $message->load('sender'),
            ]);
        }

        return back()->with('success', 'Message sent successfully.');
    }

    /**
     * Get all messages for a consultation
     */
    public function index($consultationId)
    {
        // Check if table exists
        if (!Schema::hasTable('consultation_messages')) {
            return response()->json([
                'success' => true,
                'messages' => [],
            ]);
        }

        $consultation = Consultation::with(['messages.sender'])->findOrFail($consultationId);

        // Verify user has access
        $user = Auth::user();
        $hasAccess = false;

        if ($user->role === 'Customer' && $consultation->customer_id === $user->id) {
            $hasAccess = true;
        } elseif ($user->role === 'Consultant') {
            $consultantProfile = \App\Models\ConsultantProfile::where('user_id', $user->id)->first();
            if ($consultantProfile && $consultation->consultant_profile_id === $consultantProfile->id) {
                $hasAccess = true;
            }
        }

        if (!$hasAccess) {
            abort(403, 'You do not have access to this consultation.');
        }

        // Mark messages as read
        ConsultationMessage::where('consultation_id', $consultation->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'messages' => $consultation->messages,
        ]);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead($consultationId)
    {
        $consultation = Consultation::findOrFail($consultationId);
        $user = Auth::user();

        ConsultationMessage::where('consultation_id', $consultation->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json(['success' => true]);
    }
}

