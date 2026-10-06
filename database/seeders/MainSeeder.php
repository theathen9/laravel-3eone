<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Room;
use App\Models\Payment;
use App\Models\Platform;
use App\Models\Employee;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
// use Illuminate\Support\Facades\Hash;

class MainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // seeder brand
        $dataBranches = [
            [
                'branch_code' => 'BR001',
                'branch_name' => '3E ONE Main Campus',
                'phone1' => '063 760 123',
                'phone2' => '012 345 678',
                'email' => 'main@empowermentacademy.com',
                'address' => '36, Siem Reap, Siem Reap, Cambodia',
                'location' => 'Siem Reap',
                'status' => 1,
            ],
            [
                'branch_code' => 'BR002',
                'branch_name' => '3E ONE Phnom Penh',
                'phone1' => '023 555 123',
                'phone2' => '097 555 1234',
                'email' => 'phnompenh@empowermentacademy.com',
                'address' => 'Phnom Penh, Cambodia',
                'location' => 'Phnom Penh',
                'status' => 1,
            ],
            [
                'branch_code' => 'BR003',
                'branch_name' => '3E ONE Battambang',
                'phone1' => '053 777 123',
                'phone2' => '092 777 123',
                'email' => 'battambang@empowermentacademy.com',
                'address' => 'Battambang, Cambodia',
                'location' => 'Battambang',
                'status' => 1,
            ],
            [
                'branch_code' => 'BR004',
                'branch_name' => '3E ONE Kampong Cham',
                'phone1' => '042 888 123',
                'phone2' => '095 888 123',
                'email' => 'kampongcham@empowermentacademy.com',
                'address' => 'Kampong Cham, Cambodia',
                'location' => 'Kampong Cham',
                'status' => 1,
            ],
            [
                'branch_code' => 'BR005',
                'branch_name' => '3E ONE Siem Reap West',
                'phone1' => '063 890 123',
                'phone2' => '088 890 123',
                'email' => 'west@empowermentacademy.com',
                'address' => 'Siem Reap, Cambodia',
                'location' => 'Siem Reap',
                'status' => 1,
            ],
            [
                'branch_code' => 'BR006',
                'branch_name' => '3E ONE Training Center',
                'phone1' => '063 900 123',
                'phone2' => null,
                'email' => 'training@empowermentacademy.com',
                'address' => 'Siem Reap, Cambodia',
                'location' => 'Siem Reap',
                'status' => 1,
            ],
            [
                'branch_code' => 'BR007',
                'branch_name' => '3E ONE Old Campus',
                'phone1' => '063 700 123',
                'phone2' => null,
                'email' => 'oldcampus@empowermentacademy.com',
                'address' => 'Siem Reap, Cambodia',
                'location' => 'Siem Reap',
                'status' => 0,
            ],
        ];

        foreach ($dataBranches as $item) {
            Branch::create($item);
        };

        // seeder room

        $dataRooms = [
            ['room_name' => 'Room A101', 'capacity' => 30, 'status' => 1,],
            ['room_name' => 'Room A102', 'capacity' => 30, 'status' => 1,],
            ['room_name' => 'Room A103', 'capacity' => 25, 'status' => 1,],
            ['room_name' => 'Room B201', 'capacity' => 40, 'status' => 1,],
            ['room_name' => 'Room B202', 'capacity' => 40, 'status' => 1,],
            ['room_name' => 'Room B203', 'capacity' => 35, 'status' => 1,],
            ['room_name' => 'Computer Lab 01', 'capacity' => 25, 'status' => 1,],
            ['room_name' => 'Computer Lab 02', 'capacity' => 30, 'status' => 1,],
            ['room_name' => 'Science Lab', 'capacity' => 24, 'status' => 1,],
            ['room_name' => 'English Lab', 'capacity' => 30, 'status' => 1,],
            ['room_name' => 'Library', 'capacity' => 50, 'status' => 1,],
            ['room_name' => 'Meeting Room', 'capacity' => 15, 'status' => 1,],
            ['room_name' => 'Training Hall', 'capacity' => 100, 'status' => 1,],
            ['room_name' => 'Exam Hall', 'capacity' => 80, 'status' => 1,],
            ['room_name' => 'Old Classroom', 'capacity' => 25, 'status' => 0,],
        ];

        foreach ($dataRooms as $room) {
            Room::create($room);
        }


        // seeder platforms
        $employees = Employee::orderBy('employee_id')->get();
        if ($employees->isEmpty()) {
            $this->command->warn('No employees found. Please run EmployeesSeeder first.');
            return;
        }
        $platforms = [
            ['platform_type' => 'Facebook', 'account_name' => '3E ONE Academy', 'account_url' => 'https://www.facebook.com/3eoneacademy', 'phone_number' => null,],
            ['platform_type' => 'Telegram', 'account_name' => '3E ONE Official', 'account_url' => 'https://t.me/3eoneacademy', 'phone_number' => null,],
            ['platform_type' => 'YouTube', 'account_name' => '3E ONE Academy', 'account_url' => 'https://www.youtube.com/@3eoneacademy', 'phone_number' => null,],
            ['platform_type' => 'LinkedIn', 'account_name' => '3E ONE Academy', 'account_url' => 'https://www.linkedin.com/company/3eoneacademy', 'phone_number' => null,],
            ['platform_type' => 'Website', 'account_name' => '3E ONE Academy', 'account_url' => 'https://empowermentacademy.com', 'phone_number' => null,],
        ];

        foreach ($employees as $employee) {
            /* |-------------------------------------------------------------------------- 
                            | Assign 1-3 platforms to each employee 
                            |-------------------------------------------------------------------------- */
            $employeePlatforms = fake()->randomElements($platforms, fake()->numberBetween(1, 3));
            foreach ($employeePlatforms as $platform) {
                Platform::updateOrCreate(
                    ['employee_id' => $employee->employee_id, 'platform_type' => $platform['platform_type'],],
                    ['account_name' => $platform['account_name'], 'account_url' => $platform['account_url'], 'phone_number' => $platform['phone_number'],]
                );
            }
        }


        $employees = DB::table('tblEmployees')
            ->pluck('employee_id')
            ->toArray();

        $positions = DB::table('tblPositions')
            ->pluck('position_id')
            ->toArray();

        $departments = DB::table('tblDepartments')
            ->pluck('department_id')
            ->toArray();

        if (empty($employees) || empty($positions)) {
            $this->command->warn(
                'Please seed tblEmployees and tblPositions first.'
            );

            return;
        }

        $data = [];

        foreach ($employees as $index => $employeeId) {
            // First position
            $startDate = Carbon::now()
                ->subYears(rand(1, 5))
                ->subMonths(rand(0, 11))
                ->startOfMonth();

            $endDate = (clone $startDate)
                ->addMonths(rand(6, 24))
                ->endOfMonth();

            $data[] = [
                'employee_id'  => $employeeId,
                'position_id'  => $positions[array_rand($positions)],
                'department_id' => !empty($departments)
                    ? $departments[array_rand($departments)]
                    : null,
                'start_date'   => $startDate->toDateString(),
                'end_date'     => $endDate->toDateString(),
                'remarks'      => 'Previous position - sample data.',
                'created_at'   => now(),
                'created_by'   => $employeeId,
            ];

            // Current position
            $currentStartDate = (clone $endDate)->addDay();

            $data[] = [
                'employee_id'  => $employeeId,
                'position_id'  => $positions[array_rand($positions)],
                'department_id' => !empty($departments)
                    ? $departments[array_rand($departments)]
                    : null,
                'start_date'   => $currentStartDate->toDateString(),
                'end_date'     => null,
                'remarks'      => 'Current position - sample data.',
                'created_at'   => now(),
                'created_by'   => $employeeId,
            ];
        }

        DB::table('tblEmployeePositionHistory')->insert($data);

        $this->command->info(
            count($data) . ' employee position history records seeded.'
        );

        // seeder Subject
        $dataSubject = [
            [
                'subject_code' => 'MATH101',
                'subject_name' => 'Mathematics',
            ],
            [
                'subject_code' => 'ENG101',
                'subject_name' => 'English',
            ],
            [
                'subject_code' => 'KH101',
                'subject_name' => 'Khmer Language',
            ],
            [
                'subject_code' => 'SCI101',
                'subject_name' => 'General Science',
            ],
            [
                'subject_code' => 'CS101',
                'subject_name' => 'Computer Science',
            ],
            [
                'subject_code' => 'IT101',
                'subject_name' => 'Information Technology',
            ],
            [
                'subject_code' => 'DB101',
                'subject_name' => 'Database Management',
            ],
            [
                'subject_code' => 'WEB101',
                'subject_name' => 'Web Development',
            ],
            [
                'subject_code' => 'NET101',
                'subject_name' => 'Computer Networking',
            ],
            [
                'subject_code' => 'SE101',
                'subject_name' => 'Software Engineering',
            ],
            [
                'subject_code' => 'ACC101',
                'subject_name' => 'Accounting',
            ],
            [
                'subject_code' => 'BUS101',
                'subject_name' => 'Business Management',
            ],
            [
                'subject_code' => 'ECO101',
                'subject_name' => 'Economics',
            ],
            [
                'subject_code' => 'STA101',
                'subject_name' => 'Statistics',
            ],
            [
                'subject_code' => 'PM101',
                'subject_name' => 'Project Management',
            ],
        ];

        foreach ($dataSubject as $item) {
            Subject::create($item);
        };

        DB::table('tblLevels')->insert([
            ['level_name' => 'Beginner',     'level_number' => 1],
            ['level_name' => 'Novice',       'level_number' => 2],
            ['level_name' => 'Elementary',   'level_number' => 3],
            ['level_name' => 'Intermediate', 'level_number' => 4],
            ['level_name' => 'Skilled',      'level_number' => 5],
            ['level_name' => 'Advanced',     'level_number' => 6],
            ['level_name' => 'Expert',       'level_number' => 7],
            ['level_name' => 'Master',       'level_number' => 8],
            ['level_name' => 'Elite',        'level_number' => 9],
            ['level_name' => 'Legendary',    'level_number' => 10],
        ]);


        DB::table('tblTimeSlots')->insert([
            [
                'slot_name' => '08:00-09:00',
                'start_time' => '08:00:00',
                'end_time' => '09:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '09:00-10:00',
                'start_time' => '09:00:00',
                'end_time' => '10:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '10:00-11:00',
                'start_time' => '10:00:00',
                'end_time' => '11:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '13:00-14:00',
                'start_time' => '13:00:00',
                'end_time' => '14:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '14:00-15:00',
                'start_time' => '14:00:00',
                'end_time' => '15:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '15:00-16:00',
                'start_time' => '15:00:00',
                'end_time' => '16:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '16:00-17:00',
                'start_time' => '16:00:00',
                'end_time' => '17:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '17:00-18:00',
                'start_time' => '17:00:00',
                'end_time' => '18:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '18:00-19:00',
                'start_time' => '18:00:00',
                'end_time' => '19:00:00',
                'status' => 'Active',
            ],
            [
                'slot_name' => '19:00-20:00',
                'start_time' => '19:00:00',
                'end_time' => '20:00:00',
                'status' => 'Active',
            ],
        ]);

        DB::table('tblDays')->insert([
            [
                'day_code' => 'MON',
                'day_name' => 'Monday',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'day_code' => 'TUE',
                'day_name' => 'Tuesday',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'day_code' => 'WED',
                'day_name' => 'Wednesday',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'day_code' => 'THU',
                'day_name' => 'Thursday',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'day_code' => 'FRI',
                'day_name' => 'Friday',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'day_code' => 'SAT',
                'day_name' => 'Saturday',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'day_code' => 'SUN',
                'day_name' => 'Sunday',
                'sort_order' => 7,
                'is_active' => true,
            ],
        ]);


        DB::table('tblGrades')->insert([
            [
                'grade_name' => 'A',
                'min_average' => 90.00,
                'max_average' => 100.00,
                'remark' => 'Excellent',
            ],
            [
                'grade_name' => 'B',
                'min_average' => 80.00,
                'max_average' => 89.99,
                'remark' => 'Very Good',
            ],
            [
                'grade_name' => 'C',
                'min_average' => 70.00,
                'max_average' => 79.99,
                'remark' => 'Good',
            ],
            [
                'grade_name' => 'D',
                'min_average' => 60.00,
                'max_average' => 69.99,
                'remark' => 'Average',
            ],
            [
                'grade_name' => 'E',
                'min_average' => 50.00,
                'max_average' => 59.99,
                'remark' => 'Poor',
            ],
            [
                'grade_name' => 'F',
                'min_average' => 0.00,
                'max_average' => 49.99,
                'remark' => 'Fail',
            ],
        ]);


        DB::table('tblScoreTypes')->insert([
            [
                'score_type_name' => 'Speaking',
                'percentage' => 20.00,
            ],
            [
                'score_type_name' => 'Listening',
                'percentage' => 20.00,
            ],
            [
                'score_type_name' => 'Reading',
                'percentage' => 20.00,
            ],
            [
                'score_type_name' => 'Grammar',
                'percentage' => 20.00,
            ],
            [
                'score_type_name' => 'Writing',
                'percentage' => 20.00,
            ],
        ]);


        DB::table('tblPaymentMethods')->insert([
            [
                'method_name' => 'Cash',
            ],
            [
                'method_name' => 'Payway',
            ],
            [
                'method_name' => 'Bank Transfer',
            ],
        ]);
    }
}
