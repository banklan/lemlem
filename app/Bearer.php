<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use App\Notifications\BearerResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Bearer extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname', 'email', 'password', 'phone', 'role', 'status' 
    ];

    protected $guard = 'bearer';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['account_status'];
    

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new BearerResetPasswordNotification($token));
    }

    public function getAccountStatusAttribute($value)
    {
        if($this->status == 0){
            return 'Disabled';
        }
           return 'Enabled';
    }
}
