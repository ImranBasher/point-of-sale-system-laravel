<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_id',
        'product_id',
        'unit_price',
        'quantity',
        'sub_total',
        'brand_id',
        'origin_id',
        'unit_id'
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function sales(){
        return $this->belongsTo(Sale::class,'sales_id','id');
    }


}
