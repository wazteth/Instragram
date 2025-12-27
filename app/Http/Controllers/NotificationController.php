<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Mark all unread notifications as read
        $user->unreadNotifications->markAsRead();

        // Use the auth user's notification relationship properly
        $notifications = auth()->user()
                                ->notifications() // or ->unreadNotifications() if needed
                                ->latest()
                                ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }
}
