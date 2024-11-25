<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'brand_id',
        'origin_id',
        'unit_id',
        'all_time_stock_in',
        'all_time_stock_out',
        'available_quantity'
    ];
}
