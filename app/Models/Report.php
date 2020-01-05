<?php

namespace App\Models;

use App\Scopes\PhoneLimitScope;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $primaryKey = 'id';

    protected $fillable = [
        'phoneId',
        'name',
        'email',
        'owner',
        'type',
        'message',
        'rating',
        'ip',
        'agent'
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


    protected $attributes = ['rating' => 0];

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phoneId', 'id');
    }

    protected function rules()
    {
        return array();
    }
}
