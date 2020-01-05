<?php

namespace App\Models;

use App\Scopes\PhoneLimitScope;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'phoneId',
        'value',
        'ip',
        'agent',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'id',
        'ip',
        'agent'
    ];


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
