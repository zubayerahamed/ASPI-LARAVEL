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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('slug', 150);
            
            $table->string('icon', 50)->nullable();

            $table->text('description')->nullable();

            $table->boolean('is_featured')->default(false);
            $table->boolean('is_system_defined')->default(false);
            $table->boolean('is_active')->default(true);

            $table->integer('seqn')->default(0);

            $table->foreignId("thumbnail_id")->nullable()->references("id")->on("cadocs")->nullOnDelete();
            $table->foreignId("parent_category_id")->nullable()->references("id")->on("categories")->nullOnDelete();
            $table->foreignId("business_id")->nullable()->references("id")->on("businesses")->onDelete("cascade");
            $table->unique(['slug', 'business_id']);  // category will be unique per business

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
