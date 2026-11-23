<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Branch;
use App\Models\EmployeeBranchHistory;
use App\Models\EmployeePositionHistory;
use App\Models\EmployeeSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;

class EmployeeService
{
    /**
     * Get paginated employees.
     */
    public function paginate(int $limit = 10): LengthAwarePaginator
    {
        return Employee::with([
            'branch',
            'positionHistories',
            'subjects',
        ])->paginate($limit);
    }

    /**
     * Create a new employee.
     */
    public function create(array $data): Employee
    {
        foreach (
            [
                'profile_image' => 'employees',
                'signature_image' => 'employee-signatures',
            ] as $field => $directory
        ) {
            $image = $data[$field] ?? null;
            unset($data[$field]);

            if ($image instanceof UploadedFile) {
                $data[$field] = $image->store($directory, 'public');
            }
        }

        return DB::transaction(function () use ($data) {
            unset($data['employee_code']);

            if (!empty($data['branch_id'])) {
                $branch = Branch::query()
                    ->lockForUpdate()
                    ->findOrFail($data['branch_id']);
                $data['employee_code'] = $this->nextEmployeeCode($branch);
            }

            $employee = Employee::create($data);

            if ($employee->position_id !== null) {
                $this->addPositionHistory($employee, [
                    'position_id' => $employee->position_id,
                    'department_id' => $employee->department_id,
                    'start_date' => $employee->hired_at
                        ? $employee->hired_at->toDateString()
                        : now()->toDateString(),
                    'remarks' => 'Initial position assignment.',
                ]);
            }

            if ($employee->branch_id !== null) {
                $branch = Branch::findOrFail($employee->branch_id);
                $this->addBranchHistory($employee, [
                    'branch_id' => $branch->branch_id,
                    'branch_code' => $branch->branch_code,
                    'branch_name' => $branch->branch_name,
                    'start_date' => $employee->hired_at
                        ? $employee->hired_at->toDateString()
                        : now()->toDateString(),
                    'remarks' => 'Initial branch assignment.',
                ]);
            }

            return $employee;
        });
    }

    /**
     * Find an employee.
     */
    public function find(int $id): Employee
    {
        return Employee::with([
            'branch',
            'position',
            'positionHistories.position',
            'positionHistories.department',
            'branchHistories',
            'subjects',
        ])->findOrFail($id);
    }

    /**
     * Update an existing employee.
     */
    public function update(int $id, array $data): Employee
    {
        $uploads = [];
        foreach (
            [
                'profile_image' => 'employees',
                'signature_image' => 'employee-signatures',
            ] as $field => $directory
        ) {
            $uploads[$field] = $data[$field] ?? null;
            unset($data[$field]);
        }

        return DB::transaction(function () use ($id, $data, $uploads) {
            $employee = Employee::query()
                ->lockForUpdate()
                ->findOrFail($id);
            $positionChanged = array_key_exists('position_id', $data)
                && (string) ($data['position_id'] ?? '')
                !== (string) ($employee->position_id ?? '');
            $branchChanged = array_key_exists('branch_id', $data)
                && (string) ($data['branch_id'] ?? '')
                !== (string) ($employee->branch_id ?? '');
            $targetBranchId = array_key_exists('branch_id', $data)
                ? ($data['branch_id'] ?? null)
                : $employee->branch_id;
            $oldImages = [];

            if ($employee->employee_code === null && $targetBranchId !== null) {
                $branch = Branch::query()
                    ->lockForUpdate()
                    ->findOrFail($targetBranchId);
                $data['employee_code'] = $this->nextEmployeeCode($branch);
            }

            foreach (
                [
                    'profile_image' => 'employees',
                    'signature_image' => 'employee-signatures',
                ] as $field => $directory
            ) {
                if ($uploads[$field] instanceof UploadedFile) {
                    if ($employee->{$field}) {
                        $oldImages[] = $employee->{$field};
                    }

                    $data[$field] = $uploads[$field]->store(
                        $directory,
                        'public'
                    );
                }
            }

            $employee->update($data);

            if ($positionChanged) {
                $startDate = now()->toDateString();
                $this->closeOpenPositionHistory($employee, $startDate);

                if ($employee->position_id !== null) {
                    $this->addPositionHistory($employee, [
                        'position_id' => $employee->position_id,
                        'department_id' => $employee->department_id,
                        'start_date' => $startDate,
                        'remarks' => 'Position assignment changed.',
                    ]);
                }
            }

            if ($branchChanged) {
                $startDate = now()->toDateString();
                $this->closeOpenBranchHistory($employee, $startDate);

                if ($employee->branch_id !== null) {
                    $branch = Branch::findOrFail($employee->branch_id);
                    $this->addBranchHistory($employee, [
                        'branch_id' => $branch->branch_id,
                        'branch_code' => $branch->branch_code,
                        'branch_name' => $branch->branch_name,
                        'start_date' => $startDate,
                        'remarks' => 'Branch assignment changed.',
                    ]);
                }
            }

            foreach ($oldImages as $oldImage) {
                Storage::disk('public')->delete($oldImage);
            }

            return $employee->fresh([
                'branch',
                'branchHistories',
                'positionHistories',
                'subjects',
            ]);
        });
    }

    private function closeOpenPositionHistory(
        Employee $employee,
        string $effectiveDate
    ): void {
        $effectiveDate = Carbon::parse($effectiveDate);

        foreach (
            $employee->positionHistories()->whereNull('end_date')->get()
            as $history
        ) {
            $historyStartDate = $history->start_date;
            $history->end_date = $historyStartDate->lessThan($effectiveDate)
                ? $effectiveDate->copy()->subDay()->toDateString()
                : $historyStartDate->toDateString();
            $history->save();
        }
    }

    private function closeOpenBranchHistory(
        Employee $employee,
        string $effectiveDate
    ): void {
        $effectiveDate = Carbon::parse($effectiveDate);

        foreach (
            $employee->branchHistories()->whereNull('end_date')->get()
            as $history
        ) {
            $historyStartDate = $history->start_date;
            $history->end_date = $historyStartDate->lessThan($effectiveDate)
                ? $effectiveDate->copy()->subDay()->toDateString()
                : $historyStartDate->toDateString();
            $history->save();
        }
    }

    /**
     * Delete an employee.
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $employee = Employee::findOrFail($id);

            return $employee->delete();
        });
    }

    /**
     * Add a position history record.
     */
    public function addPositionHistory(
        Employee $employee,
        array $data
    ): EmployeePositionHistory {
        return $employee->positionHistories()->create($data);
    }

    public function addBranchHistory(
        Employee $employee,
        array $data
    ): EmployeeBranchHistory {
        return $employee->branchHistories()->create($data);
    }

    private function nextEmployeeCode(Branch $branch): string
    {
        $pattern = '/^' . preg_quote($branch->branch_code, '/') . '-(\d+)$/';
        $highestSequence = 0;

        Employee::query()
            ->where('employee_code', 'like', $branch->branch_code . '-%')
            ->pluck('employee_code')
            ->each(function ($employeeCode) use ($pattern, &$highestSequence) {
                if (preg_match($pattern, (string) $employeeCode, $matches) === 1) {
                    $highestSequence = max($highestSequence, (int) $matches[1]);
                }
            });

        return sprintf('%s-%04d', $branch->branch_code, $highestSequence + 1);
    }

    /**
     * Add a subject assigned to an employee.
     */
    public function addSubject(
        Employee $employee,
        array $data
    ): EmployeeSubject {
        return $employee->subjects()->create($data);
    }
}
