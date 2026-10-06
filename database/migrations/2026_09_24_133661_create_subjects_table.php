<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblSubjects', function (Blueprint $table) {
            $table->id('subject_id');

            $table->string('subject_code', 150)->unique();
            $table->string('subject_name', 150);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblSubjects');
    }
};
