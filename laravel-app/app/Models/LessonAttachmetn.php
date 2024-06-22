<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonAttachmetn extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'lesson_attachments';
    
}
