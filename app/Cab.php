<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cab extends Model
{
    public function driver()
    {
        return $this->belongsTo('App\Driver');
    }
    public function cabtype()
    {
        return $this->belongsTo('App\CabType');
    }
}
