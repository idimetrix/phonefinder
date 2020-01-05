<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ip extends Model
{
    protected $table = 'ips';
    protected $primaryKey = 'id';
    protected $fillable = ['value'];
    protected $dates = ['created_at', 'updated_at'];
}
