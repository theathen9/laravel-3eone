<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\EmployeePositionHistory;
use App\Models\EmployeeSubject;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;

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
        $profileImage = $data['profile_image'] ?? null;

        unset($data['profile_image']);

        if ($profileImage instanceof UploadedFile) {
            $data['profile_image'] = $profileImage->store(
                'employees',
                'public'
            );
        }

        return DB::transaction(function () use ($data) {
            return Employee::create($data);
        });
    }

    /**
     * Find an employee.
     */
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
        $profileImage = $data['profile_image'] ?? null;

        unset($data['profile_image']);

        return DB::transaction(function () use (
            $id,
            $data,
            $profileImage
        ) {
            $employee = Employee::findOrFail($id);

            if ($profileImage instanceof UploadedFile) {
                $newImagePath = $profileImage->store(
                    'employees',
                    'public'
                );

                $oldImagePath = $employee->profile_image;

                $data['profile_image'] = $newImagePath;

                $employee->update($data);

                // Delete the old image after a successful update.
                if ($oldImagePath) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            } else {
                $employee->update($data);
            }

            return $employee->fresh([
                'positionHistories',
                'subjects',
            ]);
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
