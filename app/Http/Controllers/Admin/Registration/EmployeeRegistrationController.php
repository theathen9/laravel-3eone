<?php

namespace App\Http\Controllers\Admin\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeRegistrationController extends Controller
{
    public function index()
    {
        $idCodeStaff = DB::table('tblEmployees')->count() + 1;

        $autoNameFS = 'សា_' . $idCodeStaff;
        $autoNameMS = 'មា_' . $idCodeStaff;
        $autoNameLS = 'នា_' . $idCodeStaff;

        $autoNameEnFS = 'kim_' . $idCodeStaff;
        $autoNameEnMS = 'M_' . $idCodeStaff;
        $autoNameEnLS = 'Na_' . $idCodeStaff;

        $student_code = sprintf(
            'STU-%s-%02d',
            date('Y'),
            $idCodeStaff
        );

        return view('admin.registrations.employees.index', compact(
            'idCodeStaff',
            'autoNameFS',
            'autoNameMS',
            'autoNameLS',
            'autoNameEnFS',
            'autoNameEnMS',
            'autoNameEnLS',
            'student_code'
        ));
    }


    public function create()
    {
        $idCodeStaff = DB::table('tblEmployees')->count() + 1;

        return view(
            'admin.student.registrations',
            compact('idCodeStaff')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name_kh' => 'required|string|max:255',
            'middle_name_kh' => 'nullable|string|max:255',
            'last_name_kh' => 'required|string|max:255',

            'first_name_en' => 'required|string|max:255',
            'middle_name_en' => 'nullable|string|max:255',
            'last_name_en' => 'required|string|max:255',

            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'department_id' => 'required',

            'hired_at' => 'required|date',

            'email' => 'nullable|email|max:255',
            'phone1' => 'nullable|string|max:50',
            'phone2' => 'nullable|string|max:50',

            'staff_photo' => 'nullable|image|max:2048',
        ]);

        // Save employee here
        // TODO: insert into tblEmployees

        return redirect()
            ->route('admin.registrations.employees.index')
            ->with('success', 'Employee registered successfully.');
    }
}
