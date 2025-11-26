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
        Schema::create('tax_components', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique(); // e.g. VAT, SD, AIT, RD, CD
            $table->string('name', 150);
            $table->string('description')->nullable();
            $table->boolean('is_recoverable')->default(false); // e.g., VAT = true, SD = false

            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_components');
    }
};
