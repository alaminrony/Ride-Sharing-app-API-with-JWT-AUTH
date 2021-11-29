<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillChargeOption extends Model
{
    public function bill_settings()
    {
        return $this->hasMany('App\BillSettings');
    }
    public function bill_option_value()
    {
        return $this->hasMany('App\BillChargeOptionValue');
    }
}
