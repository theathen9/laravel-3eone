<?php

namespace App\Http\Controllers\Admin\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ClassModel;
use App\Models\PaymentMethod;

class StudentRegistrationController extends Controller
{
    public function index()
    {
        $total = DB::table('tblStudents')->count() + 1;
        $classes = ClassModel::query()
            ->with([
                'course',
                'teacher',
                'room',
                'timeSlot',
            ])
            ->get();
        $paymentsMethods = PaymentMethod::all();


        // dd($classes->toArray());
        // exit;
        // student
        $autoNameF = 'សា_' . $total;
        $autoNameL = 'នា_' . $total;

        $autoNameEnF = 'kim_' . $total;
        $autoNameEnL = 'Na_' . $total;




        $start = strtotime("-25 years");
        $end   = strtotime("-10 years");


        $randomTimestamp = rand($start, $end);

        $dob = date("Y-m-d", $randomTimestamp);
        $register_at = date("Y-m-d", $randomTimestamp);
        $academic_year = date("Y", $randomTimestamp) . "-" . (date("Y", $randomTimestamp) + 1);
        $email = "user" . rand(1000, 9999) . "@gmail.com";


        $idCode = sprintf(
            'STU-%02d',
            $total
        );
        $student_id = $total;

        $prefixes = [
            '010',
            '011',
            '012',
            '015',
            '016',
            '017',
            '018',
            '060',
            '061',
            '066',
            '067',
            '068',
            '069',
            '070',
            '077',
            '078',
            '085',
            '086',
            '087',
            '088',
            '089',
            '090',
            '092',
            '093',
            '095',
            '096',
            '097',
            '098',
            '099'
        ];

        $prefix = $prefixes[array_rand($prefixes)];
        $number1 = $prefix . rand(1000000, 9999999); // 7 digits
        $number2 = $prefix . rand(1000000, 9999999); // 7 digits

        // Parent/Guardian
        $autoNameGMF = 'កា_' . $total;
        $autoNameGML = 'តា_' . $total;

        $autoNameGFF = 'ដា_' . $total;
        $autoNameGFL = 'កា_' . $total;

        $emailG = "user" . rand(1000, 9999) . "@gmail.com";
        $numberG1 = $prefix . rand(1000000, 9999999); // 7 digits



        return view('admin.registrations.students.index', compact(
            'student_id',
            'idCode',
            'autoNameF',
            'autoNameL',
            'autoNameEnF',
            'autoNameEnL',
            'dob',
            'register_at',
            'academic_year',
            'email',
            'number1',
            'emailG',
            'autoNameGMF',
            'autoNameGML',
            'autoNameGFF',
            'autoNameGFL',
            'numberG1',
            'classes',
            'paymentsMethods'
        ));
    }
}
