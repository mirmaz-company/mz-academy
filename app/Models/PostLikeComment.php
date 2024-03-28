<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostLikeComment extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'post_like_comment';
}
