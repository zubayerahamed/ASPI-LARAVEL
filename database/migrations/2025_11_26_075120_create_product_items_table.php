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
            $table->string('product_behaviour', 50); // single, variant, bundle

            // Identification
            $table->string('sku', 100);  // Stock Keeping Unit, unique identifier for the product item
            $table->string('barcode', 255)->nullable();  // Barcode value EAN/UPC code
            $table->string('manufacturer_sku', 100)->nullable();  // SKU given by manufacturer
            $table->string('country_of_origin', 100)->nullable();  // Country where the product is manufactured

            // Units and Conversions
            $table->string('purchase_unit', 50)->nullable(); // kg, g, litre, ml, unit, pcs, dozen, box, packet etc. It will be declared from xcodes
            $table->decimal('purchase_conversion', 8, 2)->default(0.00); // 1, 2, 5, 10, 20 etc.
            $table->string('sell_unit', 50)->nullable(); // kg, g, litre, ml, unit, pcs, dozen, box, packet etc. It will be declared from xcodes
            $table->decimal('sell_conversion', 8, 2)->default(0.00); // 1, 2, 5, 10, 20 etc.

            // Dimensions
            $table->string('weight_unit', 20)->default('kg'); // kg, g, lb, oz etc. It will be declared from xcodes
            $table->decimal('weight', 8, 2)->default(0.00);
            $table->string('dimension_unit', 20)->default('cm'); // cm, m, inch, feet etc. It will be declared from xcodes
            $table->decimal('length', 8, 2)->default(0.00);
            $table->decimal('width', 8, 2)->default(0.00);
            $table->decimal('height', 8, 2)->default(0.00);
            
            // Shipping
            $table->decimal('volumetric_weight', 8, 2)->default(0.00); // Volumetric weight for shipping calculations
            $table->decimal('shipping_charge', 8, 2)->default(0.00);
            $table->boolean('free_shipping')->default(false);

            // Expiry Details
            $table->boolean('is_perishable')->default(false);
            $table->integer('expiry_period')->nullable();  // Number of days, months, years
            $table->string('expiry_period_type', 20)->nullable(); // days, months, years
            $table->integer('alert_before_expiry')->nullable(); // Number of days to alert before expiry
            $table->string('storage_temp_min', 10)->nullable(); // Minimum storage temperature
            $table->string('storage_temp_max', 10)->nullable(); // Maximum storage temperature
            $table->text('storage_instructions')->nullable(); // Storage instructions

            // Inventory
            $table->boolean('is_fragile')->default(false);  // Whether the product item is fragile. Use for handling instructions. Check Product Handling Profiles
            $table->boolean('is_service')->default(false);  // Whether the product item is a service, no stock management
            $table->boolean('is_digital')->default(false);  // Whether the product item is a digital product, no stock management
            $table->boolean('is_downloadable')->default(false);  // Whether the product item is downloadable, if is_digital is true
            $table->boolean('is_batch_managed')->default(false);  // Whether the product item is batch managed, stock tracked by batch numbers, can be negative stock, when it is true the is_serialized will be false
            $table->boolean('is_serialized')->default(false);  // Whether the product item is serialized, stock tracked by serial numbers and IMEI numbers, can't be negative stock
            $table->boolean('stock_track')->default(false); // Whether to track stock for this product item
            $table->enum('stock_status', ['IN_STOCK', 'OUT_OF_STOCK', 'ON_BACKORDER'])->default('IN_STOCK'); // Stock status, if stock_track is false, this field will be used to determine stock status
            $table->enum('backorder_type', ['DONT_ALLOW', 'ALLOW_NOTIFY_CUSTOMER', 'ALLOW'])->default('DONT_ALLOW');  // Backorder type, if stock goes negative
            $table->decimal('min_order_qty', 8, 2)->default(0.00);  // Customer must order at least this quantity
            $table->decimal('max_order_qty', 8, 2)->default(0.00);  // Customer can order at max this quantity
            $table->integer('lead_time_days')->default(0);  // Lead time in days for restocking
            $table->decimal('reorder_point', 8, 2)->default(0.00);  // When stock reaches this point, reorder is suggested
            $table->decimal('max_stock_level', 8, 2)->default(0.00);  // Maximum stock level to prevent overstocking

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
            
            $table->integer('prepare_time')->nullable();  // in minutes
            $table->string('warranty_type', 50)->nullable(); // No Warranty, Limited, Extended
            $table->integer('warranty_period')->nullable();  // Number of days, months, years
            $table->string('warranty_period_type', 20)->nullable(); // days, months, years
            $table->integer('download_limit')->nullable(); // If is_downloadable is true
            $table->integer('download_expiry')->nullable(); // If is_downloadable is true


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
