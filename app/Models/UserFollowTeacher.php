<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFollowTeacher extends Model
{
    use HasFactory;
    
    protected $table = 'users_follow_teacher';
}
