<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblInvoices', function (Blueprint $table) {
            $table->id('invoice_id');

            $table->string('invoice_no', 50)
                ->nullable()
                ->unique();

            $table->foreignId('student_id')
                ->constrained(
                    'tblStudents',
                    'student_id'
                );

            $table->date('invoice_date');

            $table->decimal('total_amount', 10, 2)
                ->check('total_amount >= 0');

            $table->timestamp('created_at')
                ->useCurrent();

            $table->foreignId('created_by')
                ->constrained(
                    'tblEmployees',
                    'employee_id'
                );

            $table->string('status', 50)
                ->default('Draft');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblInvoices');
    }
};
