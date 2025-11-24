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
        Schema::create('product_labels', function (Blueprint $table) {
            $table->id();

            $table->string('name', 10);
            $table->string('bg_color', 7)->default('#fe9931');
            $table->string('text_color', 7)->default('#ffffff');

            $table->boolean('is_active')->default(true);

            $table->foreignId("business_id")->nullable()->references("id")->on("businesses")->onDelete("cascade");

            $table->unique(['name', 'business_id']);  // Labels will be unique per business

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_labels');
    }
};
