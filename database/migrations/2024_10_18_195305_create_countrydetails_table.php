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
        Schema::create('countrydetails', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->text('image')->nullable();
            $table->text('country_description')->required();
            $table->text('cost_of_living')->required();
            $table->text('climate')->required();
            $table->text('language')->required();
            $table->text('scholarships')->required();
            $table->text('workOpp')->required();
            $table->text('bookMeeting')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countrydetails');
    }
};
