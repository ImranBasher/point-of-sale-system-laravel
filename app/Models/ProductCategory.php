<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'category_id'];

//    public function category(){
//
//    }

    public function productCategory(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
