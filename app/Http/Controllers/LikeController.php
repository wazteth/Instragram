<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Notifications\LikeNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

   public function store(Post $post, Request $request)
{
    try {
        $userId = auth()->id();
        $already = $post->likes()->where('user_id', $userId)->exists();
    
        if ($already) {
                $post->likes()->where('user_id', $userId)->delete();
                $liked = false;
            } else {
                $post->likes()->create(['user_id' => $userId]);
                $liked = true;

                // Check for existing like notification
                $existing = $post->user->notifications()
                    ->where('type', 'App\\Notifications\\LikeNotification')
                    ->where('notifiable_id', $post->user_id)
                    ->whereJsonContains('data->user_id', $userId)
                    ->whereJsonContains('data->post_id', $post->id)
                    ->first();

                if (!$existing && $post->user_id !== $userId) {
                    $post->user->notify(new LikeNotification(auth()->user(), $post));
                }
            }
    
        $count = $post->likes()->count();
    
        // If AJAX, return JSON
        if ($request->ajax()) {
            return response()->json([
                'liked'      => $liked,
                'like_count' => $count,
            ]);
        }
    
        // Fallback: full reload
        return back();
        // Your existing code here...
    } catch (Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}


public function destroy(Request $request, Post $post)
{
    $post->likes()->where('user_id', auth()->id())->delete();

    if ($request->ajax()) {
        return response()->json(['liked' => false, 'like_count' => $post->likes()->count()]);
    }

    return back();
}


}
