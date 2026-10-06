<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblEnrollments', function (Blueprint $table) {
            $table->id('enrollment_id');

            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');

            $table->decimal('price', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();

            $table->unique(
                ['student_id', 'class_id'],
                'uq_student_class'
            );

            $table->foreign('student_id', 'fk_enrollment_student')
                ->references('student_id')
                ->on('tblStudents')
                ->cascadeOnDelete();

            $table->foreign('class_id', 'fk_enrollment_class')
                ->references('class_id')
                ->on('tblClasses')
                ->cascadeOnDelete();

            $table->foreign('created_by', 'fk_enrollment_creator')
                ->references('employee_id')
                ->on('tblEmployees')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblEnrollments');
    }
};
