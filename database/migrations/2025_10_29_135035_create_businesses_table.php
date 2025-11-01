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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50);
            $table->string('logo', 255)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('currency', 3)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('mobile', 50)->nullable();

            $table->boolean('is_inhouse')->default(false);
            $table->boolean('is_pickup')->default(false);
            $table->boolean('is_delivery')->default(false);
            $table->boolean('is_active')->default(false);

            $table->foreignId('business_category_id')->references('id')->on('business_categories')->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
