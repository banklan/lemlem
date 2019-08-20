<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OrderSummary extends Model
{
    protected $fillable = ['order_id', 'user_id', 'item_count'];

    protected $appends = ['days_ago'];

    // protected $with = ['valet_review'];
    

    public function order()
    {
        return $this->hasMany('App\Order');
    }

    public function getDaysAgoAttribute($value)
    {
        $created = Carbon::parse($this->created_at)->diffForHumans();
        return $created;
    }

    

    // public function cuisine_review()
    // {
    //     return $this->hasMany('App\CuisineReview');
    // }
}
