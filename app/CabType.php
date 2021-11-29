<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CabType extends Model
{
    public function cab()
    {
        return $this->hasMany('App\Cab');
    }
}
