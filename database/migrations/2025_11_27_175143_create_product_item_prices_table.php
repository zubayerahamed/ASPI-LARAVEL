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
        Schema::create('product_item_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_item_id')->references('id')->on('product_items')->onDelete('cascade');

            $table->string('price_type', 50); // e.g., base, mrp, list, promo_override, contract etc. It will be declared from xcodes

            $table->decimal('amount', 8, 2)->default(0.00);
            $table->string('currency', 10)->default('BDT'); // Currency code, e.g., USD, EUR, BDT. It will be declared from xcodes. Default is BDT set from business settings

            $table->date('effective_from');
            $table->date('effective_to')->nullable();

            $table->decimal('min_quantity', 8, 2)->nullable(); // Minimum quantity for this price to be applicable
            $table->decimal('max_quantity', 8, 2)->nullable(); // Maximum quantity for this price to be applicable
            $table->string('customer_group', 50)->nullable(); // e.g., retail, wholesale, vip, etc. Null means applicable to all customers , data comes from xcodes

            $table->foreignId('business_unit_id')->nullable()->references('id')->on('business_units')->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_item_prices');
    }
};
