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
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->references('id')->on('products')->onDelete('cascade');

            // General
            $table->decimal('price', 8, 2)->default(0.00);
            $table->enum('discount_type', ['NONE', 'FLAT', 'PERCENT'])->default('NONE');
            $table->decimal('discount_amt', 8, 2)->default(0);  // Done
            $table->decimal('selling_price', 8, 2)->default(0);
            $table->boolean('is_discount_scheduled')->default(false);
            $table->date('discount_start_date')->nullable();
            $table->time('discount_start_time', $precision = 0)->nullable();
            $table->date('discount_end_date')->nullable();
            $table->time('discount_end_time', $precision = 0)->nullable();
            $table->decimal('cost_price', 8, 2)->default(0.00);

            $table->foreignId('tax_category_id')->nullable()->references('id')->on('tax_categories')->onDelete('set null');
            
            $table->string('sku', 100)->nullable();  // Done
            $table->string('barcode', 255)->nullable();  // Done
            $table->integer('prepare_time')->nullable();  // Default prepare time will be set from branch configuration or global configuration
            $table->integer('download_limit')->nullable(); // If is_downloadable is true
            $table->integer('download_expiry')->nullable(); // If is_downloadable is true

            // Inventory
            $table->boolean('stock_track')->default(false);
            $table->decimal('opening_stock', 8, 2)->default(0.00);  // Donot editable if status is published
            $table->enum('backorder_type', ['DONT_ALLOW', 'ALLOW_NOTIFY_CUSTOMER', 'ALLOW'])->default('DONT_ALLOW');
            $table->decimal('low_stock_threshold', 8, 2)->default(0.00);
            $table->enum('stock_status', ['IN_STOCK', 'OUT_OF_STOCK', 'ON_BACKORDER'])->default('IN_STOCK');
            $table->double('min_order_qty', 8, 2)->default(0.00);
            $table->double('max_order_qty', 8, 2)->default(0.00);


            $table->decimal('weight', 8, 2)->default(0.00);
            $table->decimal('length', 8, 2)->default(0.00);
            $table->decimal('width', 8, 2)->default(0.00);
            $table->decimal('height', 8, 2)->default(0.00);
            $table->decimal('shipping_charge', 8, 2)->default(0.00);
            $table->boolean('free_shipping')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
