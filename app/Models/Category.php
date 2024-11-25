<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'parent_category_id','position_no','thumbnail', 'status','created_by_id', 'updated_by_id'];

    public static  function totalCategory()
    {
        return Category::query()->count();
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'product_categories');
    }

    public function parentCategory(){
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }

}
