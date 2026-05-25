<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;

use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Notification Listing
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark As Read
     */
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);

        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        */

        if ($notification->user_id != Auth::id()) {

            abort(403);

        }

        $notification->update([
            'is_read' => true,
        ]);

        return back();
    }
}