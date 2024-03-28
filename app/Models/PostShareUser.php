<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostShareUser extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'post_share_user';
}
