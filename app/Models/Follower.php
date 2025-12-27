<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $table = 'followers';
    protected $fillable = [
        'user_id',
        'follower_id',
    ];
    // user who is being followed
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * The user who follows.
     */
    public function follower()
    {
        return $this->belongsTo(User::class, 'follower_id');
    }
}
