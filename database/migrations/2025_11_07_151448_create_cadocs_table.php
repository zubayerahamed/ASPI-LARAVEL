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
        Schema::create('cadocs', function (Blueprint $table) {

            $table->id();
            $table->string('file_name');
            $table->text('original_file_name');
            $table->string('file_extension');
            $table->string('media_type');
            $table->string('file_size');
            $table->string('compressed_file_size')->nullable();
            $table->bigInteger('original_file_size_bytes')->nullable();
            $table->bigInteger('compressed_file_size_bytes')->nullable();
            $table->decimal('compression_ratio', 5, 2)->nullable();
            $table->string('file_path');
            $table->string('file_path_compressed')->nullable();
            $table->string('alternative_name')->nullable();
            $table->string('caption')->nullable();
            $table->text('description')->nullable();
            $table->boolean('use_for_global')->default(false);
            $table->boolean('temp')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cadocs');
    }
};
