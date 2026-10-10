<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeePositionHistory;
use App\Models\EmployeeSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class EmployeeService
{

    /**
     * Get paginated employees.
     */
    public function paginate(int $limit = 10): LengthAwarePaginator
    {
        return Employee::with([
            'positionHistories',
            'subjects',
        ])->paginate($limit);
    }
    /**
     * Create a new employee.
     */
    public function create(array $data): Employee
    {
        return DB::transaction(function () use ($data) {
            return Employee::create($data);
        });
    }
    public function find(int $id): Employee
    {
        return Employee::with([
            'positionHistories',
            'subjects',
        ])->findOrFail($id);
    }

    /**
     * Update an existing employee.
     */
    public function update(int $id, array $data): Employee
    {
        return DB::transaction(function () use ($id, $data) {
            $employee = Employee::findOrFail($id);

            $employee->update($data);

            return $employee->fresh();
        });
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
