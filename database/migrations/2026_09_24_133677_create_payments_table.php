<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblPayments', function (Blueprint $table) {
            $table->id('payment_id');

            $table->foreignId('invoice_id')
                ->constrained(
                    'tblInvoices',
                    'invoice_id'
                )
                ->cascadeOnDelete();

            $table->date('payment_date');

            $table->decimal('amount', 10, 2)
                ->check('amount > 0');

            $table->foreignId('payment_method_id')
                ->constrained(
                    'tblPaymentMethods',
                    'method_id'
                );

            $table->string('reference_no', 100)
                ->nullable();

            $table->timestamp('created_at')
                ->useCurrent();

            $table->foreignId('created_by')
                ->constrained(
                    'tblEmployees',
                    'employee_id'
                );

            $table->string('status', 50)
                ->default('Completed');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblPayments');
    }
};
