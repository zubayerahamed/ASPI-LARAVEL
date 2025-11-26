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
        Schema::create('screen_business_categories', function (Blueprint $table) {
            $table->foreignId("screen_id")->references("id")->on("screens")->onDelete("cascade");
            $table->foreignId("business_category_id")->references("id")->on("business_categories")->onDelete("cascade");
            $table->primary(['screen_id', 'business_category_id']);  // unique per screen and business category
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screen_business_categories');
    }
};
