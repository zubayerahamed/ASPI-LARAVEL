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
        Schema::create('menu_screens', function (Blueprint $table) {
            $table->id();
            $table->foreignId("menu_id")->references("id")->on("menus")->onDelete("cascade");
            $table->foreignId("screen_id")->references("id")->on("screens")->onDelete("cascade");
            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");
            $table->integer('seqn')->default(0);
            $table->unique(['menu_id', 'screen_id', 'business_id']);  // unique per business
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_screens');
    }
};
