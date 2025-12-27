<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class FollowNotification extends Notification
{
    use Queueable;

    protected $follower;

    public function __construct($follower)
    {
        $this->follower = $follower;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'follow',
            'user_id' => $this->follower->id,
            'user_name' => $this->follower->username,
            'user_profile_id' => $this->follower->id,
            'message' => $this->follower->username . ' started following you.'
        ];
    }
}
