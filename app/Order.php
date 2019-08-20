<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['order_no', 'user_id', 'cuisine_id', 'units'];

    protected $appends = ['days_ago'];
    

    public function cuisine()
    {
        return $this->belongsTo('App\Cuisine');
    }

    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant');
    }

    public function order_summary()
    {
        return $this->belongsTo('App\OrderSummary');
    }

    public function getDaysAgoAttribute($value)
    {
        $created = Carbon::parse($this->created_at)->diffForHumans();
        return $created;
    }
}
