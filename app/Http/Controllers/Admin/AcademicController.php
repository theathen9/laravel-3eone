<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Course;
use Illuminate\Http\Request;


class AcademicController extends Controller
{
    public function academicYears(Request $request)
    {
        $query = AcademicYear::query();

        // Search academic years
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where('academic_year', 'like', "%{$search}%");
        }

        // Filter by status: 1 = active, 0 = inactive
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $academicYears = $query
            ->orderByDesc('start_date')
            ->paginate(10)
            ->withQueryString();

        $totalAcademicYears = AcademicYear::count();

        $activeAcademicYears = AcademicYear::where('status', 1)->count();

        $inactiveAcademicYears = AcademicYear::where('status', 0)->count();

        $currentAcademicYear = AcademicYear::where('status', 1)
            ->orderByDesc('start_date')
            ->first();

        return view('admin.academic.academic-years', compact(
            'academicYears',
            'totalAcademicYears',
            'activeAcademicYears',
            'inactiveAcademicYears',
            'currentAcademicYear'
        ));
    }

    public function academicClasses(Request $request)
    {
        $query = ClassModel::query();

        // Search classes
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where('class_name', 'like', "%{$search}%");
        }

        // Filter by status: 1 = active, 0 = inactive
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Paginated classes
        $academicClasses = $query
            ->orderBy('class_name')
            ->paginate(10)
            ->withQueryString();

        // Statistics
        $totalClasses = ClassModel::count();

        $activeClasses = ClassModel::where('status', 1)->count();

        $inactiveClasses = ClassModel::where('status', 0)->count();

        $unassignedClasses = ClassModel::whereNull('room_id')->count();

        return view('admin.academic.academic-classes', compact(
            'academicClasses',
            'totalClasses',
            'activeClasses',
            'inactiveClasses',
            'unassignedClasses'
        ));
    }
    public function academicSubjects(Request $request)
    {
        $query = Subject::query();

        // Search by subject name or subject code
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('subject_name', 'like', "%{$search}%")
                    ->orWhere('subject_code', 'like', "%{$search}%");
            });
        }

        // Filter by status only if tblSubjects has a status column
        // if ($request->filled('status')) {
        //     $query->where('status', $request->input('status'));
        // }

        // Paginate subjects
        $subjects = $query
            ->orderBy('subject_name')
            ->paginate(10)
            ->withQueryString();

        // Statistics
        $totalSubjects = Subject::count();

        // These require a status column in tblSubjects
        // $activeSubjects = Subject::where('status', 1)->count();
        // $inactiveSubjects = Subject::where('status', 0)->count();

        // Your current model does not show an assignment field.
        $unassignedSubjects = 0;

        return view('admin.academic.academic-subjects', compact(
            'subjects',
            'totalSubjects',
            // 'activeSubjects',
            // 'inactiveSubjects',
            'unassignedSubjects'
        ));
    }

    public function academicCourses(Request $request)
    {
        $query = Course::query();

        // Search by course name or course code
        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('course_name', 'like', "%{$search}%")
                    ->orWhere('course_code', 'like', "%{$search}%");
            });
        }

        // Load the related subject, if Course defines subject()
        $query->with('subject');

        // Paginate courses
        $courses = $query
            ->orderBy('course_name')
            ->paginate(10)
            ->withQueryString();

        // Statistics
        $totalCourses = Course::count();

        return view('admin.academic.academic-courses', compact(
            'courses',
            'totalCourses'
        ));
    }
}
