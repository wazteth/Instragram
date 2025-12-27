<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Post;
use App\Models\User;

class LikeNotification extends Notification
{
    use Queueable;

    protected $liker;
    protected $post;

    public function __construct(User $liker,Post $post)
    {
        $this->liker = $liker;
        $this->post = $post;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'like',
            'user_id' => $this->liker->id,
            'user_name' => $this->liker->username,
            'post_id' => $this->post->id,
            'message' => $this->liker->username . ' liked your post.',
        ];
    }
}