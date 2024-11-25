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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trx_id')->unique(); // Unique transaction ID
            $table->foreignId('purchase_id')->nullable()->constrained('purchases')->cascadeOnDelete(); // Nullable foreign key for purchase
            $table->foreignId('sale_id')->nullable()->constrained('sales')->cascadeOnDelete(); // Nullable foreign key for sale
            $table->decimal('amount', 15, 2); // Amount of the transaction
            $table->text('note')->nullable(); // Optional note
            $table->foreignId('customer_id')->nullable()->constrained('users')->cascadeOnDelete(); // Nullable foreign key for customer
          //  $table->foreignId('expense_id')->nullable()->constrained('expenses')->cascadeOnDelete(); // Nullable foreign key for expense
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['purchase_id']);
            $table->dropForeign(['sale_id']);
            $table->dropForeign(['customer_id']);
        });
        Schema::dropIfExists('transactions');
    }
};
