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
        Schema::create('product_specification_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->enum('type', ['text', 'textarea', 'select', 'checkbox', 'radio'])->default('select');
            $table->text('default_value')->nullable();
            
            $table->foreignId("group_id")->references("id")->on("product_specification_groups")->onDelete("cascade");
            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specification_attributes');
    }
};
