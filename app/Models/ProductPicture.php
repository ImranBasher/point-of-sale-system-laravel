<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPicture extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'file_path', 'extension','file_size' ];

    public function product(){
        // BelongsTo()  meaning each picture belongs to a single product.
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }



}
