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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            // future linking (nullable for now)
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name');
            $table->string('mother_name')->nullable();
            $table->string('city');
            $table->date('dob');
            $table->string('cnic', 16)->unique();
            $table->string('passport_number')->nullable();
            $table->date('passport_valid_from')->nullable();
            $table->date('passport_valid_thru')->nullable();
            $table->string('phone');
            $table->string('email')->unique();
            $table->text('address');
            $table->string('postal_code')->nullable();
            $table->string('latest_qualification')->nullable();
            $table->decimal('percentage', 4, 2)->nullable();
            $table->string('intake')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->unsignedBigInteger('applying_for_program_id')->nullable();
            $table->foreign('applying_for_program_id')->references('id')->on('program_levels')->onDelete('set null');
            $table->json('english_test')->nullable();
            $table->boolean('english_proficiency')->default(false);
            $table->boolean('account_created')->default(false);
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
