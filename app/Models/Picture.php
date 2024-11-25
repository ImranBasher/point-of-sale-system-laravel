<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{
    use HasFactory;
    protected $fillable = [
//        'filename', 'product_id', 'user_id', 'category_id', 'brand_id', 'created_at', 'updated_at'
        'filename', 'product_id','created_at', 'updated_at'
    ];

    public function product(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
