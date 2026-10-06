<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblCourses', function (Blueprint $table) {
            $table->id('course_id');

            $table->string('course_code', 50)->unique();
            $table->string('course_name', 100);

            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('level_id');

            $table->decimal('price', 10, 2);
            $table->string('duration', 50)->nullable();

            $table->foreign('subject_id', 'fk_course_subject')
                ->references('subject_id')
                ->on('tblSubjects');

            $table->foreign('level_id', 'fk_course_level')
                ->references('level_id')
                ->on('tblLevels');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblCourses');
    }
};
