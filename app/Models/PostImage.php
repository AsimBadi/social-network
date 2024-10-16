<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'post_id'
    ];

    public function profile() {
        return $this->belongsTo(Profile::class);
    }
}
