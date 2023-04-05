<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    //
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function details()
    {
        return $this->hasMany(ProductDetails::class,'product_id');
    }

}
