<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SelledItems extends Model
{
    protected $fillable = [
        'sell_id',
        'product_id',
        'price',
        'quantity',
        'tax_id',
        'tax',
        'is_service',
        'ref_id',
        'input_price',
        'cost_price',
    ];

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public function sale()
    {
        return $this->belongsTo('App\Models\Sale', 'sell_id', 'id');
    }
}
