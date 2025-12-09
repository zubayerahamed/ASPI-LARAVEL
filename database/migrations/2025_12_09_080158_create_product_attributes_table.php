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
        Schema::create('product_attributes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('attribute_id')->references('id')->on('attributes')->onDelete('cascade');
            $table->foreignId('term_id')->references('id')->on('terms')->onDelete('cascade');
            $table->boolean('use_in_variation')->default(false);

            $table->unique(['product_id', 'attribute_id', 'term_id'], 'product_attribute_term_unique');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_attributes');
    }
};
