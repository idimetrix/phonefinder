<?php

namespace App\Models;

use App\Scopes\PhoneLimitScope;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $table = 'phone';
    protected $primaryKey = 'id';

    protected $fillable = [
        'aliases',
        'area_number',
        'country',
        'number',
        'page',
        'prefix',
        'short_number',
        'url',
    ];

    protected static function boot()
    {
        parent::boot();

        self::addGlobalScope(new PhoneLimitScope());
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'phoneId', 'id');
    }

    public function likes()
    {
        return $this->hasMany(Like::class, 'phoneId', 'id');
    }

    public function likesSafe()
    {
        return $this->hasMany(Like::class, 'phoneId', 'id')->where('value', 1);
    }

    public function likesUnsafe()
    {
        return $this->hasMany(Like::class, 'phoneId', 'id')->where('value', -1);
    }

    public function views()
    {
        return $this->hasMany(View::class, 'phoneId', 'id');
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'phoneId', 'id');
    }

    public function authors()
    {
        return $this->hasMany(Author::class, 'phoneId', 'id');
    }

    public function search()
    {
        return $this->hasMany(Search::class, 'phoneId', 'id');
    }

    public function getFormatAttribute()
    {
        $this->format_number = '0 (' . $this->prefix . ') ' . substr($this->short_number, (strlen($this->prefix) + 1));

        return $this;
    }

    public function getCountryAttribute()
    {
//        $city = Country::select('location')->where('prefix',$this->prefix)->first();
//        $this->city = $city->location;
//        return $this;
    }
}
