<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyShop extends Model
{
    

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product','pro_id');
    }
}
