<?php

namespace App\Services;

use App\Models\Enrollment;
use App\Models\Invoice;
use App\Models\Score;
use App\Models\Student;
use App\Models\StudentResult;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class StudentService
{
    public function index(int $limit = 10): LengthAwarePaginator
    {
        return Student::query()
            ->with(['enrollments.class'])
            ->orderByDesc('student_id')
            ->paginate($limit);
    }

    public function find(int $id): Student
    {
        return Student::query()
            ->with(['enrollments.class'])
            ->findOrFail($id);
    }

    public function update(int $id, array $data): Student
    {
        $student = $this->find($id);
        $student->update($data);

        return $student->load(['enrollments.class']);
    }

    public function hasRecords(int $id): bool
    {
        return Enrollment::query()->where('student_id', $id)->exists()
            || Invoice::query()->where('student_id', $id)->exists()
            || Score::query()->where('student_id', $id)->exists()
            || StudentResult::query()->where('student_id', $id)->exists();
    }

    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id): bool {
            $student = Student::query()
                ->lockForUpdate()
                ->findOrFail($id);

            if ($this->hasRecords($id)) {
                return false;
            }

            return (bool) $student->delete();
        });
    }
}
