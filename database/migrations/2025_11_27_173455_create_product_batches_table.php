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
        Schema::create('product_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_item_id')->references('id')->on('product_items')->onDelete('cascade');
            $table->string('batch_number', 100);  // Batch number for the product item
            $table->date('manufacture_date')->nullable();  // Manufacture date of the batch
            $table->date('expiry_date')->nullable();  // Expiry date of the batch
            $table->decimal('quantity', 8, 2)->default(0.00);  // Quantity available in this batch

            $table->foreignId('business_unit_id')->nullable()->references('id')->on('business_units')->onDelete('set null');
            $table->foreignId('store_id')->nullable()->references('id')->on('stores')->onDelete('set null');
            $table->foreignId('business_id')->references('id')->on('businesses')->onDelete('cascade');
            // TODO: purchase_id and purchase_item_id can be added later for better tracking
            // TODO: Supplier ID can be added later for better tracking

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_batches');
    }
};
