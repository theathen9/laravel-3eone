<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblScores', function (Blueprint $table) {
            $table->id('score_id');

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

            $table->foreignId('score_type_id')
                ->constrained(
                    'tblScoreTypes',
                    'score_type_id'
                )
                ->cascadeOnDelete();

            $table->decimal('score', 5, 2)
                ->default(0);

            $table->string('academic_year', 20);

            $table->string('semester', 50)
                ->nullable();

            $table->timestamp('created_at')
                ->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblScores');
    }
};
