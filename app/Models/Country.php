<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'id';

    protected $fillable = [
        'location',
        'prefix',
        'dialing_code',
        'number_format'
    ];
}
