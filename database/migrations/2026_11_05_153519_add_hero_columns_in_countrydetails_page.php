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
        Schema::table('countrydetails', function (Blueprint $table) {
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('countrydetails', function (Blueprint $table) {
            $table->dropColumn('hero_title');
            $table->dropColumn('hero_description');
        });
    }
};
