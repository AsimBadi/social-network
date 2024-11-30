<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $appends = ['image_url', 'is_user_following'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'gender',
        'phone_no',
        'verified',
        'bio',
        'privacy',
        'profile_picture'
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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function verifyUser() {
        return $this->hasOne(VerifyUser::class);
    }

    public function getImageUrlAttribute() {
        if ($this->profile_picture) {
            return asset('storage/images/' . $this->profile_picture);
        }
        return asset('storage/images/instagram_default.png');
    }

    public function post() {
        return $this->hasMany(Post::class, 'user_id', 'id');
    }

    public function getPostAttribute() {
        return $this->post()->count();
    }

    public function followers() {
        return $this->hasMany(FollowUser::class, 'user_id', 'id');
    }

    public function getFollowerCountAttribute() {
        return $this->followers()->where('status', 2)->count();
    }

    public function followings() {
        return $this->hasMany(FollowUser::class, 'followed_by_id', 'id');
    }

    public function getFollowingsAttribute() {
        return $this->followings()->where('status', 2)->count();
    }

    public function getIsUserFollowingAttribute() {
        return FollowUser::where('followed_by_id', Auth::user()->id)->where('user_id',$this->id)->get();
    }
}
