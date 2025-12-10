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
        Schema::create('product_collection_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_collection_id')->references('id')->on('product_collections')->onDelete('cascade');
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('seqn')->default(0);

            $table->unique(['product_collection_id', 'product_id'], 'unique_product_collection_detail_product'); // unique per collection

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_collection_details');
    }
};
