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
        Schema::create('product_collections', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 150);

            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);

            $table->foreignId("thumbnail_id")->nullable()->references("id")->on("cadocs")->nullOnDelete();
            $table->foreignId("business_id")->nullable()->references("id")->on("businesses")->onDelete("cascade");

            $table->unique(['slug', 'business_id']);  // unique per business

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_collections');
    }
};
