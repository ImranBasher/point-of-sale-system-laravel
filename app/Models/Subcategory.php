<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    use HasFactory;

    protected $fillable =  [
        'title',
        'category_id',
        'position_no',
        'thumbnail',
        'status',
        'created_by_id',
        'updated_by_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
