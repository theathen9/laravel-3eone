<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblPaymentMethods', function (Blueprint $table) {
            $table->id('method_id');

            $table->string('method_name', 50)
                ->unique();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblPaymentMethods');
    }
};
