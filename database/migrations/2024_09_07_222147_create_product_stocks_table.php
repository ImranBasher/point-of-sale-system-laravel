<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete(); // Cascade on delete
            $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete(); // Set to NULL on delete
            $table->foreignId('origin_id')->nullable()->constrained('origins')->cascadeOnDelete(); // Set to NULL on delete
            $table->foreignId('unit_id')->nullable()->constrained('units')->cascadeOnDelete(); // Set to NULL on delete
            $table->integer('all_time_stock_in')->default(0); // Set to NULL on delete
            $table->integer('all_time_stock_out')->default(0); // Default value set to 0
            $table->integer('available_quantity')->default(0); // Default value set to 0
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::table('product_stocks', function (Blueprint $table) {

            $table->dropForeign(['product_id']);
            $table->dropForeign(['brand_id']);
            $table->dropForeign(['origin_id']);
            $table->dropForeign(['unit_id']);

            // Drop the columns after foreign keys are removed
            $table->dropColumn(['product_id', 'brand_id', 'origin_id', 'unit_id']);
        });

        Schema::dropIfExists('product_stocks');
    }
};
