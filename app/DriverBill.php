<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DriverBill extends Model
{
      public function billdriver()
    {
        return $this->belongsTo('App\Driver','id');
    }  
    public function billchargeoption()
    {
        return $this->belongsTo('App\BillChargeOption','id');
    }  
    public function billchargeoptionvalue()
    {
        return $this->belongsTo('App\BillChargeOptionValue','id');
    }
}
