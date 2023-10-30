<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PurchasedItems extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'price',
        'quantity',
        'tax_id',
        'tax',
    ];

    public function product(){
        return $this->hasOne('App\Models\Product', 'id', 'product_id');
    }

    public static function branchproducts()
    {
        return Product::select('products.*', 'pu.product_id as product_id')
                    ->leftjoin('purchased_items as pu', 'pu.product_id', '=', 'products.id')
                    ->where('products.created_by', '=', Auth::user()->getCreatedBy())
                    ->orderBy('products.id', 'DESC');
    }

}
