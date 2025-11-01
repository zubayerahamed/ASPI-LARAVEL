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
        Schema::create('screens', function (Blueprint $table) {
            $table->id();
            $table->string('xscreen', 10);
            $table->string('title', 50);
            $table->string('icon', 50)->nullable();
            $table->text('keywords')->nullable();

            $table->enum('type', ['Screen', 'Report', 'System', 'Default'])->default('Screen');

            $table->integer('xnum')->default(0);
            $table->integer('seqn')->default(0);

            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");

            $table->unique(['xscreen', 'business_id']);  // menu will be unique per business

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screens');
    }
};
