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
        Schema::create('profiledts', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_active')->default(false);

            $table->foreignId("profile_id")->references("id")->on("profiles")->onDelete("cascade");
            $table->foreignId("menu_screen_id")->references("id")->on("menu_screens")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiledts');
    }
};
