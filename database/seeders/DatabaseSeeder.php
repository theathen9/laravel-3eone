<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use App\Models\Branch;
use App\Models\Room;
use App\Models\Subject;
use App\Models\Platform;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Brand
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Roome
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Subject
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Level
        |--------------------------------------------------------------------------
        */

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

        /*
        |--------------------------------------------------------------------------
        | Time Slot
        |--------------------------------------------------------------------------
        */
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
        /*
        |--------------------------------------------------------------------------
        | Day
        |--------------------------------------------------------------------------
        */
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

        /*
        |--------------------------------------------------------------------------
        | Grade
        |--------------------------------------------------------------------------
        */
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
        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */

        $dataDepartments = [
            [
                'department_code' => 'ADM',
                'department_name' => 'Administration',
                'description' => 'Administration and management department',
                'status' => 1,
            ],
            [
                'department_code' => 'ACC',
                'department_name' => 'Accounting',
                'description' => 'Finance and accounting department',
                'status' => 1,
            ],
            [
                'department_code' => 'ACA',
                'department_name' => 'Academic',
                'description' => 'Academic and teaching department',
                'status' => 1,
            ],
            [
                'department_code' => 'IT',
                'department_name' => 'Information Technology',
                'description' => 'Information technology and system support',
                'status' => 1,
            ],
            [
                'department_code' => 'HR',
                'department_name' => 'Human Resources',
                'description' => 'Human resources department',
                'status' => 1,
            ],
        ];

        foreach ($dataDepartments as $item) {
            Department::create($item);
        }

        /*
        |--------------------------------------------------------------------------
        | Positions
        |--------------------------------------------------------------------------
        */

        $positions = [
            [
                'position_code' => 'DIR',
                'position_name' => 'Director',
                'description' => 'Organization director',
                'status' => 1,
            ],
            [
                'position_code' => 'ADM',
                'position_name' => 'Administrator',
                'description' => 'Administrative staff',
                'status' => 1,
            ],
            [
                'position_code' => 'ACC',
                'position_name' => 'Accountant',
                'description' => 'Accounting staff',
                'status' => 1,
            ],
            [
                'position_code' => 'TCH',
                'position_name' => 'Teacher',
                'description' => 'Teaching staff',
                'status' => 1,
            ],
            [
                'position_code' => 'DEV',
                'position_name' => 'Software Developer',
                'description' => 'Software development staff',
                'status' => 1,
            ],
            [
                'position_code' => 'HR',
                'position_name' => 'HR Officer',
                'description' => 'Human resources staff',
                'status' => 1,
            ],
        ];

        foreach ($positions as $item) {
            Position::create($item);
        }

        /*
        |--------------------------------------------------------------------------
        | Get IDs
        |--------------------------------------------------------------------------
        */

        $administration = DB::table('tblDepartments')
            ->where('department_code', 'ADM')
            ->value('department_id');

        $accounting = DB::table('tblDepartments')
            ->where('department_code', 'ACC')
            ->value('department_id');

        $academic = DB::table('tblDepartments')
            ->where('department_code', 'ACA')
            ->value('department_id');

        $it = DB::table('tblDepartments')
            ->where('department_code', 'IT')
            ->value('department_id');

        $hr = DB::table('tblDepartments')
            ->where('department_code', 'HR')
            ->value('department_id');

        $director = DB::table('tblPositions')
            ->where('position_code', 'DIR')
            ->value('position_id');

        $administrator = DB::table('tblPositions')
            ->where('position_code', 'ADM')
            ->value('position_id');

        $accountant = DB::table('tblPositions')
            ->where('position_code', 'ACC')
            ->value('position_id');

        $teacher = DB::table('tblPositions')
            ->where('position_code', 'TCH')
            ->value('position_id');

        $developer = DB::table('tblPositions')
            ->where('position_code', 'DEV')
            ->value('position_id');

        $hrOfficer = DB::table('tblPositions')
            ->where('position_code', 'HR')
            ->value('position_id');

        /*
        |--------------------------------------------------------------------------
        | Employees
        |--------------------------------------------------------------------------
        */

        $employees = [
            [
                'employee_id' => 1,
                'department_id' => $administration,
                'position_id' => $director,

                'first_name_kh' => 'សុខ',
                'last_name_kh' => 'ដារ៉ា',

                'first_name_en' => 'Dara',
                'last_name_en' => 'Sok',

                'gender' => 'Male',
                'dob' => '1985-03-15',

                'birth_village' => 'Kork Roka',
                'birth_commune' => 'Kork Roka',
                'birth_district' => 'Pur Senchey',
                'birth_province' => 'Phnom Penh',

                'curr_addr_village' => 'Boeung Keng Kang',
                'curr_addr_commune' => 'Boeung Keng Kang 1',
                'curr_addr_district' => 'Chamkarmon',
                'curr_addr_province' => 'Phnom Penh',

                'phone1' => '012345678',
                'phone2' => '098765432',
                'email' => 'dara.sok@example.com',

                'profile_image' => null,
                'hired_at' => '2015-01-10',
                'status' => 1,
            ],

            [
                'employee_id' => 2,
                'department_id' => $administration,
                'position_id' => $administrator,

                'first_name_kh' => 'ស្រីនិត',
                'last_name_kh' => 'ចាន់',

                'first_name_en' => 'Sreyneat',
                'last_name_en' => 'Chan',

                'gender' => 'Female',
                'dob' => '1992-07-20',

                'birth_village' => 'Prey Sa',
                'birth_commune' => 'Prey Sa',
                'birth_district' => 'Dangkao',
                'birth_province' => 'Phnom Penh',

                'curr_addr_village' => 'Toul Tompoung',
                'curr_addr_commune' => 'Toul Tompoung 2',
                'curr_addr_district' => 'Chamkarmon',
                'curr_addr_province' => 'Phnom Penh',

                'phone1' => '011222333',
                'phone2' => null,
                'email' => 'sreyneat.chan@example.com',

                'profile_image' => null,
                'hired_at' => '2018-04-01',
                'status' => 1,
            ],

            [
                'employee_id' => 3,
                'department_id' => $accounting,
                'position_id' => $accountant,

                'first_name_kh' => 'វិសាល',
                'last_name_kh' => 'ហេង',

                'first_name_en' => 'Visal',
                'last_name_en' => 'Heng',

                'gender' => 'Male',
                'dob' => '1989-11-05',

                'birth_village' => 'Kampong Cham',
                'birth_commune' => 'Veal Vong',
                'birth_district' => 'Kampong Cham',
                'birth_province' => 'Kampong Cham',

                'curr_addr_village' => 'Phsar Doeum Thkov',
                'curr_addr_commune' => 'Phsar Doeum Thkov',
                'curr_addr_district' => 'Chamkarmon',
                'curr_addr_province' => 'Phnom Penh',

                'phone1' => '010333444',
                'phone2' => null,
                'email' => 'visal.heng@example.com',

                'profile_image' => null,
                'hired_at' => '2017-08-15',
                'status' => 1,
            ],

            [
                'employee_id' => 4,
                'department_id' => $academic,
                'position_id' => $teacher,

                'first_name_kh' => 'រតនា',
                'last_name_kh' => 'សុខ',

                'first_name_en' => 'Rattana',
                'last_name_en' => 'Sok',

                'gender' => 'Female',
                'dob' => '1994-02-12',

                'birth_village' => 'Svay Rieng',
                'birth_commune' => 'Svay Rieng',
                'birth_district' => 'Svay Rieng',
                'birth_province' => 'Svay Rieng',

                'curr_addr_village' => 'Toul Kork',
                'curr_addr_commune' => 'Toul Kork',
                'curr_addr_district' => 'Toul Kork',
                'curr_addr_province' => 'Phnom Penh',

                'phone1' => '015444555',
                'phone2' => null,
                'email' => 'rattana.sok@example.com',

                'profile_image' => null,
                'hired_at' => '2020-01-05',
                'status' => 1,
            ],

            [
                'employee_id' => 5,
                'department_id' => $it,
                'position_id' => $developer,

                'first_name_kh' => 'សុវណ្ណ',
                'last_name_kh' => 'លី',

                'first_name_en' => 'Sovann',
                'last_name_en' => 'Ly',

                'gender' => 'Male',
                'dob' => '1996-09-18',

                'birth_village' => 'Battambang',
                'birth_commune' => 'Svay Por',
                'birth_district' => 'Battambang',
                'birth_province' => 'Battambang',

                'curr_addr_village' => 'Boeung Salang',
                'curr_addr_commune' => 'Russey Keo',
                'curr_addr_district' => 'Russey Keo',
                'curr_addr_province' => 'Phnom Penh',

                'phone1' => '017555666',
                'phone2' => null,
                'email' => 'sovann.ly@example.com',

                'profile_image' => null,
                'hired_at' => '2021-06-01',
                'status' => 1,
            ],

            [
                'employee_id' => 6,
                'department_id' => $hr,
                'position_id' => $hrOfficer,

                'first_name_kh' => 'ម៉ាលី',
                'last_name_kh' => 'កែវ',

                'first_name_en' => 'Maly',
                'last_name_en' => 'Keo',

                'gender' => 'Female',
                'dob' => '1991-12-10',

                'birth_village' => 'Kandal',
                'birth_commune' => 'Ta Khmao',
                'birth_district' => 'Kandal',
                'birth_province' => 'Kandal',

                'curr_addr_village' => 'Chbar Ampov',
                'curr_addr_commune' => 'Chbar Ampov',
                'curr_addr_district' => 'Chbar Ampov',
                'curr_addr_province' => 'Phnom Penh',

                'phone1' => '016666777',
                'phone2' => null,
                'email' => 'maly.keo@example.com',

                'profile_image' => null,
                'hired_at' => '2019-03-20',
                'status' => 1,
            ],
        ];

        foreach ($employees as $employee) {
            DB::table('tblEmployees')->updateOrInsert(
                [
                    'employee_id' => $employee['employee_id'],
                ],
                $employee
            );
        }

        $this->call([CourseSeeder::class]);
        $this->call([ClassSeeder::class]);

        $employeesP = Employee::orderBy('employee_id')->get();
        if ($employeesP->isEmpty()) {
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

        foreach ($employeesP as $employee) {
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
    }
}
