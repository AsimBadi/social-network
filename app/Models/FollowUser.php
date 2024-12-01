<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FollowUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'followed_by_id',
        'status'
    ];

    public function users() {
        return $this->belongsTo(User::class, 'followed_by_id', 'id');
    }

    public function followings() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
