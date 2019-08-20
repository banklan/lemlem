<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name'];
    

    public function restaurant()
    {
        return $this->hasMany('App\Restaurant');
    }

    public function location()
    {
        return $this->hasMany('App\Location');
    }
}
