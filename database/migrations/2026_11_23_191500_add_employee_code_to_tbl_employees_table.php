<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tblEmployees', function (Blueprint $table) {
            $table->string('employee_code', 50)->nullable()->unique();
        });

        $sequences = [];

        DB::table('tblEmployees')
            ->join(
                'tblBranches',
                'tblEmployees.branch_id',
                '=',
                'tblBranches.branch_id'
            )
            ->orderBy('tblEmployees.employee_id')
            ->select('tblEmployees.employee_id', 'tblBranches.branch_code')
            ->chunkById(100, function ($employees) use (&$sequences) {
                foreach ($employees as $employee) {
                    $branchCode = $employee->branch_code;
                    $sequences[$branchCode] = ($sequences[$branchCode] ?? 0) + 1;

                    DB::table('tblEmployees')
                        ->where('employee_id', $employee->employee_id)
                        ->update([
                            'employee_code' => sprintf(
                                '%s-%04d',
                                $branchCode,
                                $sequences[$branchCode]
                            ),
                        ]);
                }
            }, 'tblEmployees.employee_id', 'employee_id');
    }

    public function down(): void
    {
        Schema::table('tblEmployees', function (Blueprint $table) {
            $table->dropColumn('employee_code');
        });
    }
};
