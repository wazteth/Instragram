<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class CommentNotification extends Notification
{
    use Queueable;

    protected $commenter;
    protected $post;
    protected $comment;

    public function __construct($commenter, $post, $comment)
    {
        $this->commenter = $commenter;
        $this->post = $post;
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'comment',
            'user_id' => $this->commenter->id,
            'user_name' => $this->commenter->username,
            'post_id' => $this->post->id,
            'comment' => $this->comment,
            'message' => $this->commenter->username . ' commented on your post.',
        ];
    }
}
