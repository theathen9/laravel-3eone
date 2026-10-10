<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Throwable;
use App\Models\User;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Course;
use App\Models\Subject;
use App\Models\AcademicYear;

class DashboardController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalStudents' => Student::count(),
            'totalEmployees' => Employee::count(),
            'totalCourses' => Course::count(),
            'totalSubjects' => Subject::count(),
            'totalAcademicYears' => AcademicYear::count(),
            'recentSubjects' => Subject::orderByDesc('subject_id')
                ->limit(5)
                ->get(),
        ]);
    }
}
