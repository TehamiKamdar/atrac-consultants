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
        Schema::create('inquiry_holds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('consult_id'); // correct spelling
            $table->foreign('consult_id')->references('id')->on('consults')->onDelete('cascade');
            $table->text('reason')->required();
            $table->date('revisit_date')->required();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiry_holds');
    }
};
