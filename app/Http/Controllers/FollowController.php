<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Follower;
use App\Notifications\FollowNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class FollowController extends Controller
{
    public function store(User $user)
    {
        if (Auth::id() !== $user->id) {
            $exists = Follower::where('user_id', $user->id)
                ->where('follower_id', Auth::id())
                ->exists();

            if (!$exists) {
                Follower::create([
                    'user_id' => $user->id,
                    'follower_id' => Auth::id(),
                ]);

                // Send the notification using Laravel Notification system
                // Check if follow notification already exists
                $existingFollowNoti = $user->notifications()
                    ->where('type', 'App\\Notifications\\FollowNotification')
                    ->where('data->user_id', Auth::id())
                    ->first();

                if (!$existingFollowNoti) {
                    $user->notify(new FollowNotification(auth()->user()));
                }
            }
        }

        if (request()->expectsJson()) {
            return response()->json(['followerCount' => $user->followers()->count()]);
        }

        return back();
    }

    public function destroy(User $user)
    {
        if (Auth::id() !== $user->id) {
            Follower::where('user_id', $user->id)
                ->where('follower_id', Auth::id())
                ->delete();
        }

        if (request()->expectsJson()) {
            return response()->json(['followerCount' => $user->followers()->count()]);
        }

        return back();
    }
}

