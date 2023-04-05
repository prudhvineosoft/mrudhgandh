<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public function product()
    {
        return $this->belongsTo(Products::class,'product_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }   
    
}
