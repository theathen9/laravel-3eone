<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblInvoiceItems', function (Blueprint $table) {
            $table->id('item_id');

            $table->foreignId('enrollment_id')
                ->constrained(
                    'tblEnrollments',
                    'enrollment_id'
                )
                ->cascadeOnDelete();

            $table->foreignId('invoice_id')
                ->constrained(
                    'tblInvoices',
                    'invoice_id'
                )
                ->cascadeOnDelete();

            $table->string('description', 200);

            $table->decimal('amount', 10, 2)
                ->check('amount >= 0');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblInvoiceItems');
    }
};
