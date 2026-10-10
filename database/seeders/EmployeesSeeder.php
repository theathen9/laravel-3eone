<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Position;
use Illuminate\Database\Seeder;
use RuntimeException;

class EmployeesSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Departments
        |--------------------------------------------------------------------------
        */

        $administration = Department::where(
            'department_name',
            'Administration'
        )->value('department_id');

        $accounting = Department::where(
            'department_name',
            'Accounting'
        )->value('department_id');

        $academic = Department::where(
            'department_name',
            'Academic'
        )->value('department_id');

        $it = Department::where(
            'department_name',
            'Information Technology'
        )->value('department_id');

        $hr = Department::where(
            'department_name',
            'Human Resources'
        )->value('department_id');

        /*
        |--------------------------------------------------------------------------
        | Positions
        |--------------------------------------------------------------------------
        */

        $director = Position::where(
            'position_name',
            'Director'
        )->value('position_id');

        $administrator = Position::where(
            'position_name',
            'Administrator'
        )->value('position_id');

        $accountant = Position::where(
            'position_name',
            'Accountant'
        )->value('position_id');

        $teacher = Position::where(
            'position_name',
            'Teacher'
        )->value('position_id');

        $developer = Position::where(
            'position_name',
            'Software Developer'
        )->value('position_id');

        $hrOfficer = Position::where(
            'position_name',
            'HR Officer'
        )->value('position_id');

        /*
        |--------------------------------------------------------------------------
        | Validate required departments and positions
        |--------------------------------------------------------------------------
        */

        $requiredIds = [
            'Administration Department' => $administration,
            'Accounting Department' => $accounting,
            'Academic Department' => $academic,
            'Information Technology Department' => $it,
            'Human Resources Department' => $hr,

            'Director Position' => $director,
            'Administrator Position' => $administrator,
            'Accountant Position' => $accountant,
            'Teacher Position' => $teacher,
            'Software Developer Position' => $developer,
            'HR Officer Position' => $hrOfficer,
        ];

        foreach ($requiredIds as $name => $id) {
            if ($id === null) {
                throw new RuntimeException(
                    "{$name} was not found. Please seed Departments and Positions first."
                );
            }
        }

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

                'birth_addr_village' => 'Kork Roka',
                'birth_addr_commune' => 'Kork Roka',
                'birth_addr_district' => 'Pur Senchey',
                'birth_addr_province' => 'Phnom Penh',

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

                'birth_addr_village' => 'Prey Sa',
                'birth_addr_commune' => 'Prey Sa',
                'birth_addr_district' => 'Dangkao',
                'birth_addr_province' => 'Phnom Penh',

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

                'birth_addr_village' => 'Kampong Cham',
                'birth_addr_commune' => 'Veal Vong',
                'birth_addr_district' => 'Kampong Cham',
                'birth_addr_province' => 'Kampong Cham',

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

                'birth_addr_village' => 'Svay Rieng',
                'birth_addr_commune' => 'Svay Rieng',
                'birth_addr_district' => 'Svay Rieng',
                'birth_addr_province' => 'Svay Rieng',

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

                'birth_addr_village' => 'Battambang',
                'birth_addr_commune' => 'Svay Por',
                'birth_addr_district' => 'Battambang',
                'birth_addr_province' => 'Battambang',

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

                'birth_addr_village' => 'Kandal',
                'birth_addr_commune' => 'Ta Khmao',
                'birth_addr_district' => 'Kandal',
                'birth_addr_province' => 'Kandal',

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

        /*
        |--------------------------------------------------------------------------
        | Insert / Update
        |--------------------------------------------------------------------------
        */

        Employee::upsert(
            $employees,
            ['employee_id'],
            [
                'department_id',
                'position_id',
                'first_name_kh',
                'last_name_kh',
                'first_name_en',
                'last_name_en',
                'gender',
                'dob',
                'birth_addr_village',
                'birth_addr_commune',
                'birth_addr_district',
                'birth_addr_province',
                'curr_addr_village',
                'curr_addr_commune',
                'curr_addr_district',
                'curr_addr_province',
                'phone1',
                'phone2',
                'email',
                'profile_image',
                'hired_at',
                'status',
            ]
        );

        $this->command->info('Employees seeded successfully.');
    }
}
