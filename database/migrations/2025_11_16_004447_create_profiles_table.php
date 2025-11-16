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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('slug', 50);
            $table->string('description', 100)->nullable();

            $table->integer('seqn')->default(0);

            $table->boolean('is_active')->default(true);

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
        Schema::dropIfExists('profiles');
    }
};
