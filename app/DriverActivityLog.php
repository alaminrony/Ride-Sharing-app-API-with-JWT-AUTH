<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverActivityLog extends Model
{
     public function driver()
    {
        return $this->belongsTo('App\Driver');
    }
}
