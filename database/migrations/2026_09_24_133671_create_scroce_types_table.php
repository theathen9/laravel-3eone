<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblScoreTypes', function (Blueprint $table) {
            $table->id('score_type_id');

            $table->string('score_type_name', 50);

            $table->decimal('percentage', 5, 2)
                ->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblScoreTypes');
    }
};
