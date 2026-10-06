<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblPositions', function (Blueprint $table) {
            $table->id('position_id');

            $table->string('position_code')->unique();
            $table->string('position_name');
            $table->text('description')->nullable();
            $table->integer('status')->default(1);
            $table->dateTime('created_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblPositions');
    }
};
