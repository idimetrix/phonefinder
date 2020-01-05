<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleComment extends Model
{
    protected $table = 'article_comments';
    protected $primaryKey = 'id';
    protected $fillable = ['article_id', 'name', 'email', 'message'];
    protected $dates = ['created_at', 'updated_at'];
}
