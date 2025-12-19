<?php

namespace App\Http\Controllers;

use App\Models\AdminConsultantMessage;
use App\Models\ConsultantProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class AdminConsultantMessageController extends Controller
{
    /**
     * Show the messaging page for admin-consultant communication
     */
    public function showMessages($consultantId)
    {
        $consultant = ConsultantProfile::with('user')->findOrFail($consultantId);
        
        // Check if table exists
        if (!Schema::hasTable('admin_consultant_messages')) {
            return back()->withErrors(['error' => 'Messages table missing. Run migrations.']);
        }

        $messages = AdminConsultantMessage::where('consultant_profile_id', $consultant->id)
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('admin-folder.consultant-messages', compact('consultant', 'messages'));
    }

    /**
     * Store a message from admin
     */
    public function adminStore(Request $request, $consultantId)
    {
        // Check if table exists
        if (!Schema::hasTable('admin_consultant_messages')) {
            return response()->json([
                'success' => false,
                'error' => 'Messages table missing. Run migrations.',
            ], 500);
        }

        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $consultant = ConsultantProfile::findOrFail($consultantId);
        $user = Auth::user();

        if ($user->role !== 'Admin') {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized.',
            ], 403);
        }

        $message = AdminConsultantMessage::create([
            'consultant_profile_id' => $consultant->id,
            'sender_id' => $user->id,
            'sender_type' => 'admin',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender'),
        ]);
    }

    /**
     * Store a message from consultant
     */
    public function consultantStore(Request $request, $consultantId)
    {
        // Check if table exists
        if (!Schema::hasTable('admin_consultant_messages')) {
            return response()->json([
                'success' => false,
                'error' => 'Messages table missing. Run migrations.',
            ], 500);
        }

        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $consultant = ConsultantProfile::where('user_id', Auth::id())->findOrFail($consultantId);
        $user = Auth::user();

        if ($user->role !== 'Consultant') {
            return response()->json([
                'success' => false,
                'error' => 'Unauthorized.',
            ], 403);
        }

        $message = AdminConsultantMessage::create([
            'consultant_profile_id' => $consultant->id,
            'sender_id' => $user->id,
            'sender_type' => 'consultant',
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $message->load('sender'),
        ]);
    }

    /**
     * Get all messages for a consultant (AJAX)
     */
    public function index($consultantId)
    {
        // Check if table exists
        if (!Schema::hasTable('admin_consultant_messages')) {
            return response()->json([
                'success' => true,
                'messages' => [],
            ]);
        }

        $user = Auth::user();
        $consultant = ConsultantProfile::findOrFail($consultantId);

        // Verify access
        if ($user->role === 'Admin' || ($user->role === 'Consultant' && $consultant->user_id === $user->id)) {
            $messages = AdminConsultantMessage::where('consultant_profile_id', $consultant->id)
                ->with('sender')
                ->orderBy('created_at', 'asc')
                ->get();

            // Mark messages as read
            AdminConsultantMessage::where('consultant_profile_id', $consultant->id)
                ->where('sender_id', '!=', $user->id)
                ->where('is_read', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now(),
                ]);

            return response()->json([
                'success' => true,
                'messages' => $messages,
            ]);
        }

        return response()->json([
            'success' => false,
            'error' => 'Unauthorized.',
        ], 403);
    }
}



