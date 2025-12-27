<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'user_id',
        'imagePath',
        'imageUrl',
        'caption',
        'created_at',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isLikedBy($user)
    {
        if(!$user){
            return false;
        }
        if ($this->relationLoaded('likes')) {
        return $this->likes->contains('user_id', $user->id);
    }
        return $this->likes()
        ->where('user_id', $user->id)
        ->exists();
        // return $this->likes->contains('user_id', $user->id);
    }
    //like_count column later

    
}
