<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const BACKFILL_START_DATE = '2026-11-12';
    private const BACKFILL_REMARKS = 'Initial current position record (backfilled).';

    public function up(): void
    {
        DB::table('tblEmployees')
            ->whereNotNull('position_id')
            ->whereNotExists(function ($query) {
                $query->selectRaw('1')
                    ->from('tblEmployeePositionHistory')
                    ->whereColumn(
                        'tblEmployeePositionHistory.employee_id',
                        'tblEmployees.employee_id'
                    )
                    ->whereNull('tblEmployeePositionHistory.end_date');
            })
            ->orderBy('employee_id')
            ->chunkById(100, function ($employees) {
                $history = $employees->map(function ($employee) {
                    return [
                        'employee_id' => $employee->employee_id,
                        'position_id' => $employee->position_id,
                        'department_id' => $employee->department_id,
                        'start_date' => self::BACKFILL_START_DATE,
                        'end_date' => null,
                        'remarks' => self::BACKFILL_REMARKS,
                        'created_at' => now(),
                        'created_by' => null,
                    ];
                })->all();

                DB::table('tblEmployeePositionHistory')->insert($history);
            }, 'employee_id', 'employee_id');
    }

    public function down(): void
    {
        DB::table('tblEmployeePositionHistory')
            ->where('start_date', self::BACKFILL_START_DATE)
            ->where('remarks', self::BACKFILL_REMARKS)
            ->delete();
    }
};
