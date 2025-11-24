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
        Schema::create('product_specification_table_groups', function (Blueprint $table) {
            $table->foreignId("table_id")->references("id")->on("product_specification_tables")->onDelete("cascade");
            $table->foreignId("group_id")->references("id")->on("product_specification_groups")->onDelete("cascade");
            $table->foreignId("business_id")->nullable()->references("id")->on("businesses")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_specification_table_groups');
    }
};
