<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Notifications\CommentNotification;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, Post $post)
    {
        $data = $request->validate([
            'comment_text' => 'required|max:255',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'comment_text' => $data['comment_text'],
        ]);

        // Send notification to post owner
        if ($post->user_id !== auth()->id()) {
            $post->user->notify(new CommentNotification(auth()->user(), $post, $data['comment_text']));
        }
        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully.');
    }
    public function destroy(Comment $comment)
    {
        if (auth()->id() !== $comment->user_id && auth()->id() !== $comment->post->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // $postId= $comment->post_id;
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }
}
