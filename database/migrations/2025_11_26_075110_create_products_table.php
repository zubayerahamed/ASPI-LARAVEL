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

            $table->string('name', 255);  // Name of the product
            $table->string('slug', 255);  // unique per business

            $table->foreignId("brand_id")->nullable()->references("id")->on("brands")->onDelete("set null");  // Though brands cant be deleted if products exist, but just in case
            $table->foreignId("category_id")->nullable()->references("id")->on("categories")->onDelete("set null");  // Though categories cant be deleted if products exist, but just in case
            $table->string('item_group', 100);  // Services, Accessories, Finished Goods, Raw Materials, Subscriptions, Digital   // declared from xcodes

            $table->text('short_description')->nullable();  // Short description of the product
            $table->longText('description')->nullable();  // Detailed description of the product

            $table->string('product_type', 20)->default('standard'); // standard, variable, grouped, digital, external, addon, bundle/set, service, , subscription, it will be declared from xcodes

            $table->string('base_unit', 50); // kg, g, litre, ml, unit, pcs, dozen, box, packet etc. It will be declared from xcodes

            $table->boolean('is_active')->default(true);  // Whether product is active or inactive
            $table->boolean('is_listed')->default(true);  // Whether to show in storefront
            $table->boolean('is_featured')->default(true);  // Whether to show in featured section in storefront
            $table->boolean('is_trending')->default(true);  // Whether to show in trending section in storefront
            $table->boolean('is_highlighted')->default(true);  // Whether to highlight in storefront
            $table->boolean('is_for_purchase')->default(true);  // Whether available for purchase
            $table->boolean('is_for_sell')->default(true);  // Whether available for sell
            $table->boolean('is_downloadable')->default(true);  // Whether downloadable product if product_type is digital
    
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
