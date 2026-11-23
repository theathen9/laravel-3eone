<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tblEmployees')
            ->whereNotNull('employee_code')
            ->orderBy('employee_id')
            ->get(['employee_id', 'employee_code'])
            ->each(function ($employee) {
                if (!preg_match(
                    '/^(.+)-(\d+)$/',
                    $employee->employee_code,
                    $matches
                )) {
                    return;
                }

                $normalizedCode = $matches[1] . '-'
                    . str_pad($matches[2], 4, '0', STR_PAD_LEFT);

                if ($normalizedCode === $employee->employee_code) {
                    return;
                }

                $duplicateExists = DB::table('tblEmployees')
                    ->where('employee_code', $normalizedCode)
                    ->where('employee_id', '!=', $employee->employee_id)
                    ->exists();

                if ($duplicateExists) {
                    throw new RuntimeException(
                        "Cannot normalize employee code {$employee->employee_code}; "
                        . "{$normalizedCode} is already in use."
                    );
                }

                DB::table('tblEmployees')
                    ->where('employee_id', $employee->employee_id)
                    ->update(['employee_code' => $normalizedCode]);
            });
    }

    public function down(): void
    {
        // Keep normalized employee-code formatting when rolling back.
    }
};
