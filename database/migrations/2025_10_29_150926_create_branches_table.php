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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->string("address", 255)->nullable();
            $table->string("area", 100)->nullable();
            $table->string("city", 100); 
            $table->string("state", 100);
            $table->string("postal_code", 20);
            $table->string("country", 100);
            $table->string("map_link", 255)->nullable();

            $table->decimal('latitude', 11, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            $table->boolean('is_inhouse')->default(false);
            $table->boolean('is_pickup')->default(false);
            $table->boolean('is_delivery')->default(false);
            $table->boolean('is_active')->default(false);
            $table->boolean('is_orders_open')->default(false);

            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
