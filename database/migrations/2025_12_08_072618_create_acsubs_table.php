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
        Schema::create('acsubs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->enum('type', ['Customer', 'Supplier', 'Both', 'Employee', 'Sub Account']);
            $table->string('group'); // Corporate, Local, Foreign etc. values are comes from xcodes table

            $table->foreignId("business_id")->references("id")->on("businesses")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acsubs');
    }
};
