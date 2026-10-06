<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // data role
        $dataRole = [
            [
                'role_name' => 'Admin',
                'description' => 'System administrator',
            ],
            [
                'role_name' => 'Account',
                'description' => 'Accountant user',
            ],
            [
                'role_name' => 'Teacher',
                'description' => 'Teacher user',
            ],
            [
                'role_name' => 'Student',
                'description' => 'Student user',
            ]
        ];

        foreach ($dataRole as $item) {
            Role::updateOrinsert($item);
        };



        // Permission seeder
        $dataPermission = [
            [
                'permission_name' => 'MANAGE_SYSTEM',
                'description' => 'Permission to manage system settings and configurations',
            ],
            [
                'permission_name' => 'MANAGE_USERS',
                'description' => 'Permission to manage users',
            ],
            [
                'permission_name' => 'MANAGE_PERMISSIONS',
                'description' => 'Permission to manage permissions',
            ],
            [
                'permission_name' => 'MANAGE_ROLES',
                'description' => 'Permission to manage roles',
            ],
            [
                'permission_name' => 'MANAGE_ASSIGN_PERMISSIONS',
                'description' => 'Permission to assign permissions to users',
            ],
            [
                'permission_name' => 'EMPLOYEE_MANAGE',
                'description' => 'Permission to manage employees',
            ],
            [
                'permission_name' => 'STUDENT_MANAGE',
                'description' => 'Permission to manage students',
            ],
            [
                'permission_name' => 'ATTENDANCE_MANAGE',
                'description' => 'Permission to manage attendance records',
            ],
            [
                'permission_name' => 'SCORE_MANAGE',
                'description' => 'Permission to manage student scores',
            ],
            [
                'permission_name' => 'CLASS_MANAGE',
                'description' => 'Permission to manage classes',
            ],
            [
                'permission_name' => 'SCHEDULE_MANAGE',
                'description' => 'Permission to manage schedules',
            ],
            [
                'permission_name' => 'ASSIGNMENT_MANAGE',
                'description' => 'Permission to manage assignments',
            ],
            [
                'permission_name' => 'EXAM_MANAGE',
                'description' => 'Permission to manage exams',
            ],
            [
                'permission_name' => 'FINANCE_MANAGE',
                'description' => 'Permission to manage finance records',
            ],
            [
                'permission_name' => 'FINANCE_MANAGE',
                'description' => 'Permission to manage finance records',
            ],
            [
                'permission_name' => 'REPORTS_MANAGE',
                'description' => 'Permission to manage reports',
            ],
            [
                'permission_name' => 'CAN_VIEW',
                'description' => 'Permission to can view',
            ],
            [
                'permission_name' => 'CAN_CREATE',
                'description' => 'Permission to can create',
            ],
            [
                'permission_name' => 'CAN_EDIT',
                'description' => 'Permission to can edit',
            ],
            [
                'permission_name' => 'CAN_DELETE',
                'description' => 'Permission to can delete',
            ]
        ];

        foreach ($dataPermission as $item) {
            Permission::updateOrinsert($item);
        };

        // Role Permission
        $dataRolePermission = [
            // Admin role permissions
            ['role_id' => 1, 'permission_id' => 1],
            ['role_id' => 1, 'permission_id' => 2],
            ['role_id' => 1, 'permission_id' => 3],
            ['role_id' => 1, 'permission_id' => 4],
            ['role_id' => 1, 'permission_id' => 5],
            ['role_id' => 1, 'permission_id' => 6],
            ['role_id' => 1, 'permission_id' => 7],
            ['role_id' => 1, 'permission_id' => 8],
            ['role_id' => 1, 'permission_id' => 9],
            ['role_id' => 1, 'permission_id' => 10],
            ['role_id' => 1, 'permission_id' => 11],
            ['role_id' => 1, 'permission_id' => 12],
            ['role_id' => 1, 'permission_id' => 13],
            ['role_id' => 1, 'permission_id' => 14],
            ['role_id' => 1, 'permission_id' => 15],
            ['role_id' => 1, 'permission_id' => 16],
            // Account role permissions
            ['role_id' => 2, 'permission_id' => 6],
            ['role_id' => 2, 'permission_id' => 7],
            ['role_id' => 2, 'permission_id' => 8],
            ['role_id' => 2, 'permission_id' => 9],
            ['role_id' => 2, 'permission_id' => 10],
            ['role_id' => 2, 'permission_id' => 11],
            ['role_id' => 2, 'permission_id' => 12],
            ['role_id' => 2, 'permission_id' => 13],
            ['role_id' => 2, 'permission_id' => 14],
            ['role_id' => 2, 'permission_id' => 15],
            ['role_id' => 2, 'permission_id' => 16],
            // Teacher role permissions
            ['role_id' => 3, 'permission_id' => 7],
            ['role_id' => 3, 'permission_id' => 8],
            ['role_id' => 3, 'permission_id' => 9],
            ['role_id' => 3, 'permission_id' => 10],
            ['role_id' => 3, 'permission_id' => 11],
            ['role_id' => 3, 'permission_id' => 12],
            ['role_id' => 3, 'permission_id' => 13],
            ['role_id' => 3, 'permission_id' => 14],
            ['role_id' => 3, 'permission_id' => 15],
            ['role_id' => 3, 'permission_id' => 16],
            // Student role permissions
            ['role_id' => 4, 'permission_id' => 7],
            ['role_id' => 4, 'permission_id' => 8],
            ['role_id' => 4, 'permission_id' => 9],
            ['role_id' => 4, 'permission_id' => 10],
            ['role_id' => 4, 'permission_id' => 11],
            ['role_id' => 4, 'permission_id' => 12],
            ['role_id' => 4, 'permission_id' => 13],
            ['role_id' => 4, 'permission_id' => 14],
            ['role_id' => 4, 'permission_id' => 15],
            ['role_id' => 4, 'permission_id' => 16],
            // Additional permissions for specific roles can be added here
        ];
        foreach ($dataRolePermission as $item) {
            RolePermission::updateOrinsert($item);
        };
    }
}
