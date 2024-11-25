<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique(); // Invoice number for sale
            $table->foreignId('customer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('salesman_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('sub_total', 10, 2);
            $table->integer('total_quantity')->default(0);
            $table->enum('discount_type', [0, 1, 2])->default(0);
            $table->decimal('discount_value', 6, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('shipping_amount', 5, 2)->default(0);
            $table->decimal('vat_amount', 5, 2)->default(0);
            $table->decimal('tax_amount', 5, 2)->default(0);
            $table->decimal('grand_total', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->decimal('due_amount', 15, 2)->default(0);
            $table->enum('payment_status', ['0', '1'])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('sales', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropForeign(['salesman_id']);
        });
        Schema::dropIfExists('sales');
    }
};
