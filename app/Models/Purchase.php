<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'customer_id',
        'supplier_id',
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
    public static function totalPurchase(){
        return Purchase::query()->where('status', '1')->count();  // Counting purchases with status 1
    }
    public static function duesPurchase(){
        return Purchase::query()->where('payment_status', '0')->count();
    }
    public function purchase_product(){
        return $this->hasMany(PurchaseProduct::class);
    }

    public function product(){
        return $this->purchase_product()->product();
    }
    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }



    public function user(){
        return $this->belongsTo(User::class);
    }

    public function customer(){
        return $this->belongsTo(User::class, 'customer_id');
    }
}
