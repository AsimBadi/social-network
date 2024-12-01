<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'caption',
        'user_id'
    ];

    public function image() {
        return $this->hasMany(PostImage::class, 'post_id', 'id');
    }

    public function likes() {
        return $this->hasMany(PostLike::class, 'post_id', 'id');
    }

    public function getLikesCountAttribute() {
        return $this->likes()->where('post_id', $this->id)->count();
    }

    public function getUserLikesAttribute() {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

    public function followers() {
        return $this->hasMany(FollowUser::class, 'user_id', 'id');
    }
}
