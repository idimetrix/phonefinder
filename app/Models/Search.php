<?php

namespace App\Models;

use App\Scopes\PhoneLimitScope;
use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    protected $table = 'search';
    protected $primaryKey = 'id';

    protected $fillable = [
        'phoneId',
        'count',
        'search',
        'ip',
        'agent'
    ];

    protected $hidden = ['id', 'ip', 'agent'];

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
