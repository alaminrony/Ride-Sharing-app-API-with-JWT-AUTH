<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CabRide extends Model
{
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }
    public function passenger()
    {
        return $this->belongsTo('App\Passenger');
    }
    public function ridestatus()
    {
        return $this->belongsTo('App\RideStatus');
    }
    public function cancelride()
    {
        return $this->hasMany('App\RideCancel');
    }
    
}
