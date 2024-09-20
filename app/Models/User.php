<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Friend;
use App\Models\FriendRequest;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = "users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     public function run()
     {
         User::factory()
                 ->count(20)
                 ->hasPosts(1)
                 ->create();
     }

    protected $fillable = [
        'firstName',
        'lastName',
        'userName',
        'birthDate',
        'gender',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->where(function ($query) {
                        $query->where('user_id', $this->id)
                              ->orWhere('friend_id', $this->id);
                    });
    }

    public function isFriendWith(User $user)
    {
        return $this->friends()->where('friends.friend_id', $user->id)->exists();
    }

    public function totalFriends() {
        return Friend::where('user_id', $this->id)
                ->orWhere('friend_id', $this->id)
                ->count();
    }

    public function sentFriendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'sender_id');
    }

    public function friendRequests()
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id');
    }

}
