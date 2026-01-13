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
        Schema::create('student_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnUpdate();
            $table->enum('level', ['matric', 'intermediate', 'bachelors', 'masters']);
            $table->string('institute');
            $table->string('board');
            $table->string('subject');
            $table->double('obtained_marks', 6, 2);
            $table->double('total_marks', 6, 2);
            $table->year('passing_year');
            $table->string('grade_or_cgpa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_educations');
    }
};
