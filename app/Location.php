<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['name', 'city_id'];

    protected $with = ['city'];


    public function city()
    {
        return $this->belongsTo('App\City');
    }

    public function user()
    {
        return $this->hasMany('App\User');
    }

    public function restaurant()
    {
        return $this->hasMany('App\Restaurant');
    }
}
