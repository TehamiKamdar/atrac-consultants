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
        Schema::create('student_english_tests', function (Blueprint $table) {
            $table->id();

            // Foreign key to students table
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');

            // Test name (only these 3 allowed)
            $table->enum('test_name', ['IELTS', 'TOEFL', 'PTE']);
            // Optional fields for score or test date
            $table->decimal('listening', 3, 1)->nullable();
            $table->decimal('reading', 3, 1)->nullable();
            $table->decimal('speaking', 3, 1)->nullable();
            $table->decimal('writing', 3, 1)->nullable();
            $table->decimal('score', 3, 1)->nullable();
            $table->date('test_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_english_tests');
    }
};
