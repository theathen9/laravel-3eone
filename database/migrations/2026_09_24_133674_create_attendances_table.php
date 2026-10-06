<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblAttendances', function (Blueprint $table) {
            $table->id('attendance_id');

            $table->foreignId('enrollment_id')
                ->constrained(
                    'tblEnrollments',
                    'enrollment_id'
                )
                ->cascadeOnDelete();

            $table->date('attendance_date');

            $table->string('status', 20)
                ->default('Absent');

            $table->string('remarks', 255)
                ->nullable();

            $table->foreignId('created_by')
                ->nullable()
                ->constrained(
                    'tblEmployees',
                    'employee_id'
                )
                ->cascadeOnDelete();

            $table->unique(
                ['enrollment_id', 'attendance_date', 'created_by'],
                'uq_attendance'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblAttendances');
    }
};
