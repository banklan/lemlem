<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['user_id', 'order_no', 'cuisine_id', 'restaurant_id', 'rating'];

   
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }
}
