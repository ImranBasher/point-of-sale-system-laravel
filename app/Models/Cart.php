<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $casts =[
        'quantity'      => 'decimal:2',
        'unit_price'    => 'decimal:2',
        'sub_total'     => 'decimal:2',
    ];

    protected $fillable = [
        'product_id',
        'unit_price',
        'quantity',
        'sub_total'
    ];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
