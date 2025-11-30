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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150); // Name of the brand
            $table->string('slug', 150); // URL-friendly version of the brand name

            $table->foreignId('thumbnail_id')->nullable()->references('id')->on('cadocs')->onDelete('set null'); // Reference to the logo document in cadocs table

            $table->string('website', 255)->nullable(); // Brand's official website
            $table->text('description')->nullable(); // Description of the brand

            // Core active state
            $table->boolean('is_active')->default(true); // Whether the brand is active or not

            // UI flags (should be separate, but okay if you insist)
            $table->boolean('is_featured')->default(false); // Whether the brand is featured
            $table->boolean('is_popular')->default(false); // Whether the brand is popular
            $table->boolean('is_highlighted')->default(false); // Whether the brand is highlighted
            $table->boolean('is_listed')->default(true); // Whether the brand is listed

            $table->string('country_of_origin', 100)->nullable(); // Country where the brand originates from
            // Optional future-proof ERP fields
            $table->string('support_email')->nullable();
            $table->string('support_phone', 50)->nullable();
            $table->string('warranty_period')->nullable();  // e.g. “1 year”

            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");
            $table->unique(['slug', 'business_id']);
            // index helpers
            $table->index(['business_id', 'is_active']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
