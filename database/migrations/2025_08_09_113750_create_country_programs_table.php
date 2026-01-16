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
        Schema::create('country_programs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('program_level_id');

            $table->timestamps();

            // Foreign keys
            $table->foreign('country_id')
                  ->references('id')
                  ->on('countries')
                  ->onDelete('cascade');

            $table->foreign('program_level_id')
                  ->references('id')
                  ->on('program_levels')
                  ->onDelete('cascade');

            // Optional: prevent duplicate entries
            $table->unique(['country_id', 'program_level_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('country_programs');
    }
};
