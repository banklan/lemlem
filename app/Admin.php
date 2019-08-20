<?php

namespace App;

use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
// use Illuminate\Foundation\Auth\User;

class Admin extends Authenticatable
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

    protected $guard = 'admin';

    protected $appends = ['account_status', 'self'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
        
    }

    public function getAccountStatusAttribute($value)
    {
        if($this->status == 0){
            return 'Disabled';
        }
           return 'Enabled';
    }

    public function getSelfAttribute($value)
    {   
        if(Auth::guard('admin')->user()->id == $this->id){
            return true;
        }
            return false;
    }

    public function setFullnameAttribute($value)
    {
        $this->attributes['fullname'] = ucwords($value);
    }

}
