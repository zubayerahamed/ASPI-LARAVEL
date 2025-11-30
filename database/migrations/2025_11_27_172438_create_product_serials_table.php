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
        Schema::create('product_serials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_item_id')->references('id')->on('product_items')->onDelete('cascade');

            $table->string('serial_number', 255); // Serial number or IMEI number
            $table->enum('status', ['IN_STOCK', 'SOLD', 'RETURNED', 'DAMAGED', 'UNDER_REPAIR', 'IN_TRANSFER'])->default('IN_STOCK');
            $table->date('warranty_expiry_date')->nullable();  // Warranty expiry date
            $table->text('notes')->nullable();  // Additional notes about the serial number

            // TODO: Sales reference can be added later when sales module is done
            $table->foreignId('business_unit_id')->nullable()->references('id')->on('business_units')->onDelete('set null');
            $table->foreignId('store_id')->nullable()->references('id')->on('stores')->onDelete('set null');
            // TODO: Purchase reference can be added later when purchase module is done
            $table->foreignId('business_id')->references('id')->on('businesses')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_serials');
    }
};
