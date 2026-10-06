<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblClasses', function (Blueprint $table) {
            $table->id('class_id');

            $table->string('class_name', 100)->nullable();
            $table->string('class_code', 50)->unique();

            $table->unsignedBigInteger('course_id');

            $table->string('academic_year', 9);

            $table->unsignedInteger('max_students')->default(50);
            $table->unsignedInteger('current_students')->default(0);

            $table->string('status', 50)->default('Active');

            // Optional assignments
            $table->unsignedBigInteger('teacher_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('slot_id')->nullable();

            $table->foreign('course_id', 'fk_class_course')
                ->references('course_id')
                ->on('tblCourses');

            $table->foreign('teacher_id', 'fk_class_teacher')
                ->references('employee_id')
                ->on('tblEmployees');

            $table->foreign('room_id', 'fk_class_room')
                ->references('room_id')
                ->on('tblRooms');

            $table->foreign('slot_id', 'fk_class_slot')
                ->references('slot_id')
                ->on('tblTimeSlots');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblClasses');
    }
};
