<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotVisit extends Model
{
    protected $table = 'bot_visits';
    protected $primaryKey = 'id';
    protected $fillable = ['agent', 'count'];
}
