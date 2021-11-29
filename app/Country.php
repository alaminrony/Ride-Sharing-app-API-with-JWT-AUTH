<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public function bill_settings()
    {
        return $this->hasMany('App\BillSettings');
    }
}
