<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'title', 'body'];
    protected $dates = ['created_at', 'updated_at'];

    public function articleComments()
    {
        return $this->hasMany(ArticleComment::class, 'article_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
