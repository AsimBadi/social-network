<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
