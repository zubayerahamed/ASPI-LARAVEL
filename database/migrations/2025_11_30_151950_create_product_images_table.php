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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreignId('product_item_id')->nullable()->references('id')->on('product_items')->onDelete('cascade');
            $table->foreignId('cadoc_id')->references('id')->on('cadocs')->onDelete('cascade');
            $table->boolean('is_primary')->default(false);  // Whether this image is the primary image for the product
            $table->integer('seqn')->default(0); // Order of display for multiple images
            $table->string('alt_text')->nullable(); // Alternative text for the image
            $table->string('caption')->nullable(); // Caption for the image
            $table->string('usage_context')->default('thumbnail'); // e.g., gallery, thumbnail, zoomed, swatch etc.

            $table->foreignId('business_id')->references('id')->on('businesses')->onDelete('cascade');
            
            $table->unique(['product_item_id', 'cadoc_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
