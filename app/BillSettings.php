<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillSettings extends Model
{
    public function country()
    {
        return $this->belongsTo('App\Country');
    }
    public function billchargeoption()
    {
        return $this->belongsTo('App\BillChargeOption');
    }
    public function billchargeoptionvalue()
    {
        return $this->belongsTo('App\BillChargeOptionValue');
    }
}
