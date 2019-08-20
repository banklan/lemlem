<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function cuisine()
    {
        return $this->hasMany('App\Cuisine');
    }
}
