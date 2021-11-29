<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RideStatus extends Model
{
    public function cabride()
    {
        return $this->hasMany('App\CabRide');
    }
    public function ridecancel()
    {
        return $this->hasMany('App\RideCancel');
    }
}
