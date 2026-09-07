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
        Schema::table('student_applications', function (Blueprint $table) {
            // Rename program_id to program_level_id
            $table->renameColumn('program_id', 'program_level_id');

            // Add course name
            $table->string('course_name')->nullable()->after('program_level_id');
        });
    }

    public function down(): void
    {
        Schema::table('student_applications', function (Blueprint $table) {
            // Remove course name
            $table->dropColumn('course_name');

            // Rename back
            $table->renameColumn('program_level_id', 'program_id');
        });
    }
};
