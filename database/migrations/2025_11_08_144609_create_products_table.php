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
            $table->string('product_id');
            $table->string('category_id');
            $table->string('subcategory_id');
            $table->string('sub_subcategory_id');
            $table->string('brand');
            $table->string('quantity');
            $table->string('weight');

            $table->string('product');
            $table->string('mrp');
            $table->string('selling_price');
            $table->string('discount');
            $table->string('image');

            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
