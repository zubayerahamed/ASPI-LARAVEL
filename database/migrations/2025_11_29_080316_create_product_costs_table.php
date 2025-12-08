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
        Schema::create('product_costs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_item_id')->references('id')->on('product_items')->onDelete('cascade');
            $table->decimal('cost_price', 10, 2)->default(0.00);
            $table->decimal('additional_costs', 10, 2)->default(0.00); // e.g., shipping, handling
            $table->decimal('total_cost', 10, 2)->default(0.00); // cost_price + additional_costs
            
            $table->date('effective_from')->nullable(); // Date when this cost becomes effective
            $table->date('effective_to')->nullable(); // Date when this cost is no longer effective

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_costs');
    }
};
