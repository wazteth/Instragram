<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use Notifiable;

    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'profile_picture',
        'bio',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

//     public function getRouteKeyName()
// {
//     return 'username';
// }


    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }  
    public function followers()
{
    return $this->hasMany(Follower::class, 'user_id');
}

    public function following()
{
    return $this->hasMany(Follower::class, 'follower_id');
    // stories() and notifications() methods can be added similarly 
}
    public function stories(): HasMany
    {
        return $this->hasMany(Story::class);
    }

    public function notifications()
    {
        return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable')
                    ->orderBy('created_at', 'desc');
    }

    // Add this method to access only unread notifications
    public function unreadNotifications()
    {
        return $this->notifications()->whereNull('read_at');
    }
}