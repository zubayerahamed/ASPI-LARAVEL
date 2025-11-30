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
        Schema::create('product_tag_assignments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('business_id')->references('id')->on('businesses')->onDelete('cascade');
            $table->unique(['tag_id', 'product_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tag_assignments');
    }
};
