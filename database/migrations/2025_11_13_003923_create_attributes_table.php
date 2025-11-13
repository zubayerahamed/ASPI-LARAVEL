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
        Schema::create('attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 50);

            $table->enum('display_layout', ['TEXT_SWATCH', 'DROPDOWN_SWATCH', 'VISUAL_SWATCH'])->default('TEXT_SWATCH');

            $table->boolean('is_image_visual_swatch')->default(false);
            $table->boolean('is_searchable')->default(false);
            $table->boolean('is_comparable')->default(false);
            $table->boolean('is_used_in_product_listing')->default(false);
            $table->boolean('is_active')->default(true);

            $table->integer('seqn')->default(0);

            $table->foreignId("business_id")->nullable()->references("id")->on("businesses")->onDelete("cascade");
            $table->unique(['slug', 'business_id']);  // attribute will be unique per business

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attributes');
    }
};
