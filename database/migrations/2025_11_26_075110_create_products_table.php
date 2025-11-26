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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);
            $table->string('slug', 255);
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();

            $table->string('item_group', 100);  // Services, Accessories, Finished Goods, Raw Materials for physical products and Software, Subscriptions for digital products
            $table->string('item_category', 100)->nullable();

            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(true);
            $table->boolean('is_trending')->default(true);
            $table->boolean('is_highlighted')->default(true);
            $table->boolean('is_for_purchase')->default(true);
            $table->boolean('is_for_sell')->default(true);
            $table->boolean('is_digital')->default(true);
            $table->boolean('is_downloadable')->default(true);
    
            $table->string('product_type', 20)->default('simple'); // simple, variable, grouped, external, addon, bundle

            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");
            $table->unique(['slug', 'business_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
