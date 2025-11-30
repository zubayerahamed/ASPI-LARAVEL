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
        Schema::create('product_label_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_label_id')->references('id')->on('product_labels')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('product_item_id')->nullable()->references('id')->on('product_items')->onDelete('cascade');
            
            // Only one of product_id OR product_item_id should exist

            $table->foreignId('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_label_assignments');
    }
};
