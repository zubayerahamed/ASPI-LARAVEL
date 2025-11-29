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
        Schema::create('product_discounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_item_id')->references('id')->on('product_items')->onDelete('cascade');

            $table->string('discount_type', 50); // e.g., percentage, fixed_amount
            $table->decimal('amount', 8, 2)->default(0.00);
            $table->date('starts_at');
            $table->date('ends_at')->nullable();
            $table->string('customer_group', 50)->nullable(); // e.g., retail, wholesale, vip, etc. Null means applicable to all customers , data comes from xcodes
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_discounts');
    }
};
