<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tblPlatforms', function (Blueprint $table) {
            $table->id('platform_id');

            $table->unsignedBigInteger('employee_id')->nullable();

            $table->string('platform_type', 20);
            $table->string('account_name', 150)->nullable();
            $table->string('account_url', 255)->nullable();
            $table->string('phone_number', 20)->nullable();

            $table->foreign('employee_id', 'fk_platform_employee')
                ->references('employee_id')
                ->on('tblEmployees')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tblPlatforms');
    }
};
