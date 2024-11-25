<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected  $fillable = [
        'invoice_no',
        'customer_id',
        'salesman_id',
        'sub_total',
        'total_quantity',
        'discount_type',
        'discount_value',
        'discount_amount',
        'shipping_amount',
        'vat_amount',
        'tax_amount',
        'grand_total',
        'paid_amount',
        'due_amount',
        'payment_status',
        'status'
    ];

    public static function totalSale(){
        return Sale::query()->where('status', '1')->count();  // Counting sales with status 1
    }
    public static function duesSale(){
        return Sale::query()->where('payment_status', '0')->count();
    }






    // saleProducts(),   customer(),  salesman()  for transaction
    public function salesProducts(){
        return $this->hasMany(SalesProduct::class, 'sales_id');
    }

    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }
    public function salesman(){
        return $this->belongsTo(User::class, 'salesman_id');
    }

}
