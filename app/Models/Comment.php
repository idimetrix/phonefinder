<?php

namespace App\Models;

use App\Scopes\PhoneLimitScope;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comments';
    protected $primaryKey = 'id';

   protected $fillable = [
        'phoneId',
        'name',
        'email',
        'type',
        'message',
        'rating',
        'ip',
        'agent'
    ];

    protected $hidden = ['id', 'ip', 'agent'];
    protected $attributes = ['rating' => 0];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope(new PhoneLimitScope('phoneId'));
    }

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phoneId', 'id');
    }

    protected function rules()
    {
        return array();
    }
}
