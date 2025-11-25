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
        Schema::create('product_option_details', function (Blueprint $table) {
            $table->id();
            $table->string('label', 100);
            $table->decimal('additional_price', 10, 2)->default(0.00);
            $table->enum('price_type', ['fixed', 'percentage'])->default('fixed');
            $table->integer('seqn')->default(0);

            $table->foreignId("product_option_id")->references("id")->on("product_options")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_option_details');
    }
};
