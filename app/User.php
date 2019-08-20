<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\UserResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'address', 'location_id', 'phone', 'alt_phone', 'area_code' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $with = ['location'];

    protected $appends = ['account_status'];


    public function cuisine_review()
    {
        return $this->hasMany('App\CuisineReview');
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords($value);
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function getAccountStatusAttribute($value)
    {
        if($this->status == 0){
            return 'Disabled';
        }
           return 'Enabled';
    }
}
