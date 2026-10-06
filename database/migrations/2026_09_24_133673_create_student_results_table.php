<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblStudentResults', function (Blueprint $table) {
            $table->id('result_id');

            $table->foreignId('student_id')
                ->constrained(
                    'tblStudents',
                    'student_id'
                )
                ->cascadeOnDelete();

            $table->foreignId('class_id')
                ->constrained(
                    'tblClasses',
                    'class_id'
                )
                ->cascadeOnDelete();

            $table->string('academic_year', 20);

            $table->decimal('total_score', 6, 2)
                ->nullable();

            $table->decimal('average_score', 5, 2)
                ->nullable();

            $table->foreignId('grade_id')
                ->nullable()
                ->constrained(
                    'tblGrades',
                    'grade_id'
                )
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblStudentResults');
    }
};
