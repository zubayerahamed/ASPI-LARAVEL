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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();

            $table->enum('label', ['home', 'office', 'other'])->nullable();
            $table->string('contact_name', 100)->nullable();
            $table->string('contact_phone_1', 20)->nullable();
            $table->string('contact_phone_2', 20)->nullable();

            $table->enum('address_type', ['billing', 'shipping', 'pickup', 'other'])->default('billing');

            $table->string('address_line_1', 255);
            $table->string('address_line_2', 255)->nullable();
            $table->string('address_line_3', 255)->nullable();
            $table->string('landmark', 255)->nullable();

            $table->string('street')->nullable();
            $table->string('district')->nullable();
            $table->string('sub_district')->nullable();

            $table->string('postal_code', 20)->nullable()->index();

            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();

            $table->text('full_address')->nullable();

            $table->boolean('is_default')->default(false);

            $table->foreignId('country_id')->constrained('countries')->onDelete('cascade');
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
