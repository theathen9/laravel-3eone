<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblTimetables', function (Blueprint $table) {
            $table->id('timetable_id');

            $table->unsignedBigInteger('class_id');
            $table->unsignedBigInteger('day_id');

            $table->timestamp('created_at')->useCurrent();

            $table->unique(
                ['class_id', 'day_id'],
                'uq_timetable'
            );

            $table->foreign('class_id', 'fk_timetable_class')
                ->references('class_id')
                ->on('tblClasses')
                ->cascadeOnDelete();

            $table->foreign('day_id', 'fk_timetable_day')
                ->references('day_id')
                ->on('tblDays')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblTimetables');
    }
};
