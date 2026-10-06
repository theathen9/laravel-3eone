<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblEmployeeSubjects', function (Blueprint $table) {
            $table->id('employee_subject_id');

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('subject_id');

            $table->unique(
                ['employee_id', 'subject_id'],
                'uq_employee_subject'
            );

            $table->foreign('employee_id', 'fk_employee_subject_employee')
                ->references('employee_id')
                ->on('tblEmployees')
                ->cascadeOnDelete();

            $table->foreign('subject_id', 'fk_employee_subject_subject')
                ->references('subject_id')
                ->on('tblSubjects')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblEmployeeSubjects');
    }
};
