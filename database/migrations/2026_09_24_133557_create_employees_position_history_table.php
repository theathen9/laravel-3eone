<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblEmployeePositionHistory', function (Blueprint $table) {
            $table->id('position_history_id');

            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('position_id');
            $table->unsignedBigInteger('department_id')->nullable();

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->text('remarks')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('created_by')->nullable();

            // Foreign keys
            $table->foreign('employee_id', 'fk_position_history_employee')
                ->references('employee_id')
                ->on('tblEmployees')
                ->cascadeOnDelete();

            $table->foreign('position_id', 'fk_position_history_position')
                ->references('position_id')
                ->on('tblPositions')
                ->restrictOnDelete();

            $table->foreign('department_id', 'fk_position_history_department')
                ->references('department_id')
                ->on('tblDepartments')
                ->nullOnDelete();

            $table->foreign('created_by', 'fk_position_history_creator')
                ->references('employee_id')
                ->on('tblEmployees')
                ->nullOnDelete();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblEmployeePositionHistory');
    }
};
