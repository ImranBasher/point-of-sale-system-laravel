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
        Schema::create('origins', function (Blueprint $table) {
            $table->id();
            $table->string('origin_name');
            $table->enum('status', [1, 0])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('origins');
    }
};

//
//use Illuminate\Database\Migrations\Migration;
//use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
//
//return new class extends Migration
//{
//    /**
//     * Run the migrations.
//     */
//    public function up(): void
//    {
//        Schema::table('products', function (Blueprint $table) {
//            $table->renameColumn('name', 'title');
//
//            $table->dropForeign(['category_id']);
//            $table->dropColumn('category_id');
//
//            $table->string('sku')->unique()->after('slug');
//
//            $table->dropColumn('description');
//
//            $table->text('short_description')->nullable()->after('sku');
//            $table->longText('long_description')->nullable()->after('short_description');
//
//            $table->string('thumbnail')->nullable()->after('long_description');
//            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
//            $table->foreignId('created_by_id')->nullable()->after('thumbnail')->constrained('users')->cascadeOnDelete();
//            $table->foreignId('updated_by_id')->nullable()->after('created_by_id')->constrained('users')->cascadeOnDelete();
//        });
//    }
//
//    /**
//     * Reverse the migrations.
//     */
//    public function down(): void
//    {
//        Schema::table('products', function (Blueprint $table) {
//            $table->renameColumn('title', 'name');
//            $table->foreignId('category_id')->constrained();
//            $table->dropUnique(['sku']);
//            $table->dropColumn('sku');
//            $table->text('description')->nullable()->after('brand_id');
//            $table->dropColumn(['short_description', 'long_description']);
//            $table->dropColumn('thumbnail');
//            $table->dropForeign(['user_id']);
//            $table->dropForeign(['created_by_id']);
//            $table->dropForeign(['updated_by_id']);
//            $table->dropColumn(['user_id', 'created_by_id', 'updated_by_id']);
//
//
//        });
//    }
//};
