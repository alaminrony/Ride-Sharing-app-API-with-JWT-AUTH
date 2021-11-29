<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Passenger extends Authenticatable implements JWTSubject{
	 // authenticate: start
    use Notifiable;

        protected $guard = 'passenger';

        protected $fillable = [
            'p_first_name','p_last_name', 'p_email', 'password',
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];


    // authenticate: end


    public function cabride()
    {
        return $this->hasMany('App\CabRide');
    }
    public function cancelride()
    {
        return $this->hasMany('App\RideCancel');
    }
    
    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
}
