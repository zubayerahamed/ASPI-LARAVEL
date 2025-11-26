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
        Schema::create('tax_rule_components', function (Blueprint $table) {
            $table->id();

            $table->decimal('rate', 8, 2)->default(0.00); // e.g., 15.00 for 15%
            $table->enum('calc_type', ['exclusive', 'inclusive', 'compound', 'exempt'])->default('exclusive');
            $table->unsignedSmallInteger('seqn')->default(1); // order of application (lower first)
            $table->boolean('is_recoverable')->nullable(); // override of tax_components.is_recoverable if needed

            $table->foreignId("tax_rule_id")->references("id")->on("tax_rules")->onDelete("cascade");
            $table->foreignId("tax_component_id")->references("id")->on("tax_components")->onDelete("cascade");

            $table->unique(['tax_rule_id', 'tax_component_id']); // one component per rule once
            $table->index(['tax_rule_id', 'seqn']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tax_rule_components');
    }
};
