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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->nullable();
            $table->foreignId('category_id')->constrained();
            $table->foreignId('brand_id')->constrained();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // Increased precision to match validation
            $table->decimal('discount', 5, 2)->nullable(); // Updated to decimal for percentage values
            $table->decimal('total_quantity', 10, 2); // Increased precision to match validation
            $table->decimal('remain_quantity', 10, 2)->nullable(); // Ensure this matches your requirements
            $table->tinyInteger('warranty')->nullable();
            $table->enum('status', [0, 1])->default(1); // Ensure the enum values are correct
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['brand_id']);
        });
        Schema::dropIfExists('products');
    }
};
