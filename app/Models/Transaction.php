<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;


    protected $fillable = [
        'trx_id',
        'purchase_id',
        'sales_id',
        'amount',
        'note',
        'customer_id'
    ];


    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }


    public function purchaseProduct(){
        return $this->purchase()->purchase_product();
    }

    public function product(){
        return $this->purchase_product()->product();
    }
    public function user(){
        return $this->belongsTo(User::class,'customer_id','id');
    }


    public function userAdmin(){   // who give money to supplier
        return $this->belongsTo(User::class,'customer_id','id');
    }




    public function sales(){
        return $this->belongsTo(Sale::class);
    }

    public function saleCustomer(){
        return $this->belongsTo(User::class, 'customer_id', 'id');
    }
}
