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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('xmenu', 10);
            $table->string('title', 50);
            $table->string('icon', 50)->nullable();
            $table->integer('seqn')->default(0);

            $table->foreignId("parent_menu_id")->nullable()->references("id")->on("menus")->onDelete("cascade");
            $table->foreignId("business_id")->nullable()->references("id")->on("businesses")->onDelete("cascade");

            $table->unique(['xmenu', 'business_id']);  // menu will be unique per business

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
