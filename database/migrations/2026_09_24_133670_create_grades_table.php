<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblGrades', function (Blueprint $table) {
            $table->id('grade_id');

            $table->string('grade_name', 50);

            $table->decimal('min_average', 5, 2)
                ->nullable();

            $table->decimal('max_average', 5, 2)
                ->nullable();

            $table->string('remark', 100)
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblGrade');
    }
};
