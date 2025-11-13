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
        Schema::create('terms', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 50);
            $table->string('color', 7)->nullable(); // Hex color code

            $table->boolean('is_default')->default(false);

            $table->integer('seqn')->default(0);

            $table->foreignId("thumbnail_id")->nullable()->references("id")->on("cadocs")->nullOnDelete();
            $table->foreignId("attribute_id")->references("id")->on("attributes")->onDelete("cascade");
            $table->foreignId("business_id")->nullable()->references("id")->on("businesses")->onDelete("cascade");

            $table->unique(['slug', 'attribute_id', 'business_id']);  // term will be unique per attribute and business

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('terms');
    }
};
