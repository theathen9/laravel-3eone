<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tblEmployees', function (Blueprint $table) {
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id', 'fk_employees_branch')
                ->references('branch_id')
                ->on('tblBranches')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('tblEmployees', function (Blueprint $table) {
            $table->dropForeign('fk_employees_branch');
            $table->dropColumn('branch_id');
        });
    }
};
