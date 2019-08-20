<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['name', 'picture', 'address', 'opening_hrs', 'city_id'];

    protected $table = 'restaurants';

    protected $appends = ['slug'];

    protected $with = ['rating', 'cuisine_review', 'location'];
    

    public function city(){
        return $this->belongsTo('App\City');
    }

    public function location(){
        return $this->belongsTo('App\Location');
    }

    public function cuisine()
    {
        return $this->hasMany('App\Cuisine');
    }

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function getSlugAttribute($value)
    {
        $slug = str_slug($this->name);

        return $slug;
    }

    public function cuisine_review()
    {
        return $this->hasMany('App\CuisineReview');
    }

    public function rating()
    {
        return $this->hasMany('App\Rating');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

}
