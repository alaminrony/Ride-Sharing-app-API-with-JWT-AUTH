<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverType extends Model
{
    
	public function driver()
    {
        return $this->hasMany('App\Driver');
    }
}
