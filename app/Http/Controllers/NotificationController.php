<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\ConsultationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Mark notification as read and redirect to the most relevant page.
     */
    public function go($id, Request $request)
    {
        $user = Auth::user();

        /** @var ConsultationNotification|null $notification */
        $notification = ConsultationNotification::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Mark as read
        if (!$notification->is_read) {
            $notification->is_read = true;
            $notification->save();
        }

        $consultation = $notification->consultation;
        if (!$consultation) {
            return $this->fallbackRedirect($user->role);
        }

        // Decide destination based on role + notification type/title
        if ($user->role === 'Customer') {
            // If report ready, send straight to report view
            if ($notification->title === 'Consultation Report Ready') {
                return redirect()->route('customer.consultations.report', $consultation->id);
            }

            // For proposals / status changes, send to My Consultations list, highlighting this row
            return redirect()->route('customer.my-consults', ['highlight' => $consultation->id]);
        }

        if ($user->role === 'Consultant') {
            // For most consultant notifications, open the specific request page when possible
            if (in_array($notification->type, ['proposal', 'status_change'], true)) {
                // If route fails for some reason, fall back to list
                try {
                    return redirect()->route('consultant.consultations.open', $consultation->id);
                } catch (\Throwable $e) {
                    // ignore and fall back
                }
            }

            return redirect()->route('consultant.consultations', ['highlight' => $consultation->id]);
        }

        // Admin or other roles – just go to a sensible dashboard
        return $this->fallbackRedirect($user->role);
    }

    protected function fallbackRedirect(string $role)
    {
        if ($role === 'Customer') {
            return redirect()->route('customer.my-consults');
        }

        if ($role === 'Consultant') {
            return redirect()->route('consultant.consultations');
        }

        if ($role === 'Admin') {
            return redirect()->route('dashboard.admin');
        }

        return redirect()->route('dashboard');
    }
}


