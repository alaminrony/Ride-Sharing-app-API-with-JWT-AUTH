<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillChargeOptionValue extends Model
{
    protected $fillable = [
        'bill_charge_option_id', 'option_value_name','option_value_status'
    ];

    public function bill_settings()
    {
        return $this->hasMany('App\BillSettings');
    }
     public function billchargeoption()
    {
        return $this->belongsTo('App\BillChargeOption');
    }
}
