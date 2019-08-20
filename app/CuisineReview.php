<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class CuisineReview extends Model
{
    protected $fillable = ['user_id', 'order_id', 'cuisine_id', 'restaurant_id', 'comments'];

    protected $appends = ['reviewed_date'];

    protected $with = ['user'];


    public function cuisine()
    {
        return $this->belongsTo('App\Cuisine');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getReviewedDateAttribute($key)
    {
        $date = Carbon::parse($this->created_at)->toFormattedDateString();
        return $date;
    }
}
