<?php

namespace App\Models;

use App\Models\ArticleAttachment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'articles';

    public function images()
    {
        return $this->hasMany(ArticleAttachment::class,'article_id','id');
    }
}
