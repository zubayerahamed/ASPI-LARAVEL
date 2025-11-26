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
        Schema::create('tax_rules', function (Blueprint $table) {
            $table->id();
            $table->text('notes')->nullable();

            $table->enum('transaction_type', ['sales', 'purchase']);
           
            $table->date('effective_from');
            $table->date('effective_to')->nullable();

            $table->foreignId("tax_category_id")->references("id")->on("tax_categories")->onDelete("cascade");
            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_rules');
    }
};
