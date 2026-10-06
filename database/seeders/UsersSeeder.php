<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $dataUsers = [
            [
                'user_id' => 1,
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('Admin@12345'),
                'role_id' => 1,
                'reference_id' => 1,
                'reference_type' => 'Employee',
                'status' => 1,
            ],
            [
                'user_id' => 2,
                'username' => 'Account',
                'email' => 'account@gmail.com',
                'password' => bcrypt('Account@12345'),
                'role_id' => 2,
                'reference_id' => 2,
                'reference_type' => 'Employee',
                'status' => 1,
            ],
            [
                'user_id' => 3,
                'username' => 'Teacher',
                'email' => 'teacher@gmail.com',
                'password' => bcrypt('Teacher@12345'),
                'role_id' => 3,
                'reference_id' => 3,
                'reference_type' => 'Employee',
                'status' => 1,
            ]
        ];
        foreach ($dataUsers as $item) {
            DB::table('tblUsers')->updateOrInsert(
                [
                    'user_id' => $item['user_id'],
                ],
                $item
            );
        };
    }
}
