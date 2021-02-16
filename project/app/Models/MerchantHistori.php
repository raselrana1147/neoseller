<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class MerchantHistori extends Model
{
    protected $fillable=['merchant_id','pro_id','order_id','commission'];

    public function merchant()
    {
        return $this->belongsTo('App\Models\Admin','merchant_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','pro_id');
    }
}
