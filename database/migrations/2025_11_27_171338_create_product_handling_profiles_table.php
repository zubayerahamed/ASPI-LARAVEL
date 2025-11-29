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
        Schema::create('product_handling_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_item_id')->references('id')->on('product_items')->onDelete('cascade');
            $table->string('profile_name', 255);  // Name of the handling profile, e.g., "Fragile", "perishable", "heavy", 'hazardous', 'Needs special packaging' etc. declared from xcodes 
            $table->text('instructions')->nullable();  // Special handling instructions
            $table->decimal('handling_fee', 8, 2)->default(0.00); // Additional fee for special handling
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_handling_profiles');
    }
};
