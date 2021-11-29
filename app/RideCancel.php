<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RideCancel extends Model
{
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }
    public function passenger()
    {
        return $this->belongsTo('App\Passenger');
    }
	public function cabride()
    {
        return $this->belongsTo('App\CabRide');
    }
    public function ridestatus()
    {
        return $this->belongsTo('App\RideStatus');
    }
}
