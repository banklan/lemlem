<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    protected $fillable = ['amount', 'user_id', 'order_no'];
}
