<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuisine extends Model
{
    protected $fillable = ['restaurant_id', 'cuisine_uid', 'name', 'category', 'price'];

    protected $with = ['restaurant', 'category', 'cuisine_review'];

    protected $appends = ['slug'];
    

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function setCuisineUidAttributes()
    {
        $this->attributes['cuisine_uid'] = $this->restaurant_id.'-'.$this->id;
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function getSlugAttribute($value)
    {
        $slug = str_slug($this->name);

        return $slug;
    }

    public function order()
    {
        return $this->belongsToMany('App\Order');
    }

    public function cuisine_review()
    {
        return $this->hasMany('App\CuisineReview');
    }
}
