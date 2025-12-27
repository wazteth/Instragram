<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['user_id', 'notifier_id', 'type', 'post_id', 'read'];

    public function notifier() {
        return $this->belongsTo(User::class, 'notifier_id');
    }

    public function post() {
        return $this->belongsTo(Post::class);
    }
}
