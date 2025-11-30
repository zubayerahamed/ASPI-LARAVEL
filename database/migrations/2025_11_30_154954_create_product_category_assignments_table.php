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
        Schema::create('product_category_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->boolean('is_primary')->default(false); // Whether this category is the primary category for the product

            $table->foreignId('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->unique(['category_id', 'product_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_category_assignments');
    }
};
