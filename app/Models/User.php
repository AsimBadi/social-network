<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    protected $appends = ['image_url', 'is_user_following', 'gender_name', 'privacy_name'];
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
        'profile_picture',
        'is_banned'
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
        return asset('assets/images/instagram_default/Default_pfp.jpg');
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

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getPrivacyNameAttribute()
    {
        switch ($this->privacy) {
            case '1':
                return 'Public';
                break;
            
            case '2':
                return 'Private';
                break;
            
            default:
                return 'Not Defined';
                break;
        }
    }

    public function getGenderNameAttribute()
    {
        switch ($this->gender) {
            case '1':
                return 'Male';
                break;
            
            case '2':
                return 'Female';
                break;
            
            default:
                return 'Not Defined';
                break;
        }
    }

    public function suspendedUser()
    {
        return $this->hasOne(SuspendedUser::class, 'user_id', 'id');
    }
}
