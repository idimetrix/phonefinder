<?php

namespace App\Models;

use App\Scopes\PhoneLimitScope;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $table = 'views';
    protected $primaryKey = 'id';
    protected $fillable = [
        'phoneId',
        'count',
        'ip',
        'agent',
        'views_count',
        'created_at'
    ];

    protected $hidden = ['id', 'agent', 'updated_at'];


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
