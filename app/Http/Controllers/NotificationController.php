<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    /**
     * Mark a single notification as read.
     */
    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        $notification = $user->notifications()->where('id', $id)->first();

        if (! $notification) {
            return back()->with('error', __('Notification not found'));
        }

        $notification->markAsRead();

        return back();
    }
}
