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
        Schema::create('xcodes', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('xcode');
            $table->string('description')->nullable();
            $table->integer('seqn')->default(0);

            $table->foreignId("business_id")->nullable()->references("id")->on("businesses")->onDelete("cascade");

            $table->unique(['type', 'xcode', 'business_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xcodes');
    }
};
