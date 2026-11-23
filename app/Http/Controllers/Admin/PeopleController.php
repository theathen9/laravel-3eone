<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Student;
use App\Models\Enrollment;

class PeopleController extends Controller
{
    // public function index(Request $request): View
    // {
    //     $query = Employee::query()
    //         ->with('position');

    //     // Search employees
    //     if ($request->filled('search')) {
    //         $search = trim($request->string('search')->toString());

    //         $query->where(function ($q) use ($search) {
    //             $q->where('first_name_en', 'like', "%{$search}%")
    //                 ->orWhere('last_name_en', 'like', "%{$search}%")
    //                 ->orWhere('employee_code', 'like', "%{$search}%")
    //                 ->orWhere('email', 'like', "%{$search}%")
    //                 ->orWhere('phone', 'like', "%{$search}%");
    //         });
    //     }

    //     // Filter by status
    //     if ($request->filled('status')) {
    //         if ($request->status === 'active') {
    //             $query->where(function ($q) {
    //                 $q->where('status', 'active')
    //                     ->orWhere('status', 1)
    //                     ->orWhere('status', '1');
    //             });
    //         } elseif ($request->status === 'inactive') {
    //             $query->where(function ($q) {
    //                 $q->whereNull('status')
    //                     ->orWhere(function ($subQuery) {
    //                         $subQuery->where('status', '!=', 'active')
    //                             ->where('status', '!=', '1');
    //                     });
    //             });
    //         }
    //     }

    //     $employees = $query
    //         ->orderByDesc('employee_id')
    //         ->paginate(10)
    //         ->withQueryString();

    //     // Summary statistics
    //     $activeCount = Employee::where(function ($q) {
    //         $q->where('status', 'active')
    //             ->orWhere('status', 1)
    //             ->orWhere('status', '1');
    //     })->count();

    //     $inactiveCount = Employee::where(function ($q) {
    //         $q->whereNull('status')
    //             ->orWhere(function ($subQuery) {
    //                 $subQuery->where('status', '!=', 'active')
    //                     ->where('status', '!=', '1');
    //             });
    //     })->count();

    //     // Change this condition if your position model stores
    //     // teacher categories differently.
    //     $teacherCount = Employee::whereHas('position', function ($q) {
    //         $q->where('position_name', 'like', '%teacher%');
    //     })->count();

    //     return view('admin.people.employees', [
    //         'employees' => $employees,
    //         'totalEmployees' => Employee::count(),
    //         'activeEmployees' => Employee::where('status', 'active')->count(),
    //         'inactiveEmployees' => Employee::where('status', 'inactive')->count(),
    //         'teacherEmployees' => $teacherCount,
    //     ]);
    // }

    public function employees(Request $request)
    {
        $query = Employee::with(['position', 'branch']);

        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('first_name_en', 'like', "%{$search}%")
                    ->orWhere('last_name_en', 'like', "%{$search}%")
                    ->orWhere('employee_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('branch', function ($branchQuery) use ($search) {
                        $branchQuery->whereRaw(
                            'LOWER(branch_code) LIKE ?',
                            ['%' . mb_strtolower($search) . '%']
                        );
                    });

                if (ctype_digit($search)) {
                    $q->orWhere('employee_id', (int) $search);
                }
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $employees = $query
            ->orderByDesc('employee_id')
            ->paginate(10)
            ->withQueryString();

        $totalEmployees = Employee::count();
        $activeEmployees = Employee::where('status', '1')->count();
        $inactiveEmployees = Employee::where('status', '0')->count();

        $teacherEmployees = Employee::whereHas('position', function ($q) {
            $q->whereRaw('LOWER(position_name) LIKE ?', ['%teacher%']);
        })->count();

        return view('admin.people.employees', compact(
            'employees',
            'totalEmployees',
            'activeEmployees',
            'inactiveEmployees',
            'teacherEmployees'
        ));
    }

    public function teachers(Request $request)
    {
        // Only employees whose position is Teacher
        $query = Employee::with(['position', 'branch'])
            ->whereHas('position', function ($q) {
                $q->whereRaw('LOWER(position_name) LIKE ?', ['%teacher%']);
            });

        // Search teachers
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('first_name_en', 'like', "%{$search}%")
                    ->orWhere('last_name_en', 'like', "%{$search}%")
                    ->orWhere('first_name_kh', 'like', "%{$search}%")
                    ->orWhere('last_name_kh', 'like', "%{$search}%")
                    ->orWhere('employee_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone1', 'like', "%{$search}%")
                    ->orWhereHas('branch', function ($branchQuery) use ($search) {
                        $branchQuery->whereRaw(
                            'LOWER(branch_code) LIKE ?',
                            ['%' . mb_strtolower($search) . '%']
                        );
                    });

                if (ctype_digit($search)) {
                    $q->orWhere('employee_id', (int) $search);
                }
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Paginated teacher list
        $teachers = $query
            ->orderByDesc('employee_id')
            ->paginate(10)
            ->withQueryString();

        // Statistics for teachers only
        $totalTeachers = Employee::whereHas('position', function ($q) {
            $q->whereRaw('LOWER(position_name) LIKE ?', ['%teacher%']);
        })->count();

        $activeTeachers = Employee::whereHas('position', function ($q) {
            $q->whereRaw('LOWER(position_name) LIKE ?', ['%teacher%']);
        })->where('status', 1)->count();

        $inactiveTeachers = Employee::whereHas('position', function ($q) {
            $q->whereRaw('LOWER(position_name) LIKE ?', ['%teacher%']);
        })->where('status', 0)->count();

        $unassignedTeachers = Employee::whereHas('position', function ($q) {
            $q->whereRaw('LOWER(position_name) LIKE ?', ['%teacher%']);
        })->whereNull('department_id')->count();

        return view('admin.people.teachers', compact(
            'teachers',
            'totalTeachers',
            'activeTeachers',
            'inactiveTeachers',
            'unassignedTeachers'
        ));
    }
    public function students(Request $request)
    {
        // Query students
        $query = Student::query();

        // Search students
        if ($request->filled('search')) {
            $search = trim($request->input('search'));

            $query->where(function ($q) use ($search) {
                $q->where('first_name_en', 'like', "%{$search}%")
                    ->orWhere('last_name_en', 'like', "%{$search}%")
                    ->orWhere('first_name_kh', 'like', "%{$search}%")
                    ->orWhere('last_name_kh', 'like', "%{$search}%")
                    ->orWhere('student_code', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Student registration uses text statuses, while older records may use 1/0.
        if ($request->filled('status')) {
            $status = strtolower((string) $request->input('status'));

            if (in_array($status, ['1', 'active'], true)) {
                $query->whereIn('status', ['1', 'active']);
            } elseif (in_array($status, ['0', 'inactive'], true)) {
                $query->whereIn('status', ['0', 'inactive']);
            } else {
                $query->where('status', $status);
            }
        }

        // Paginated student list
        $students = $query
            ->orderByDesc('student_id')
            ->paginate(10)
            ->withQueryString();

        // Student statistics
        $totalStudents = Student::count();

        $activeStudents = Student::whereIn('status', ['1', 'active'])->count();

        $inactiveStudents = Student::whereIn('status', ['0', 'inactive'])->count();

        $unassignedStudents = Student::whereDoesntHave('enrollments')->count();

        return view('admin.people.students', compact(
            'students',
            'totalStudents',
            'activeStudents',
            'inactiveStudents',
            'unassignedStudents'
        ));
    }

    public function showStudent(Student $student): View
    {
        $student->load('enrollments.class');

        return view('admin.people.student-details', compact('student'));
    }
}
