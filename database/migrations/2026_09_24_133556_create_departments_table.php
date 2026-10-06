<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblDepartments', function (Blueprint $table) {
            $table->id('department_id');
            $table->string('department_code', 20)->unique();
            $table->string('department_name', 100);
            $table->text('description')->nullable();
            $table->smallInteger('status')->default(1);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblDepartments');
    }
};
