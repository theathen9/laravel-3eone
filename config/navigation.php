<?php

return [

    'admin' => [

        [
            'title' => 'Dashboard',
            'icon' => 'bi bi-speedometer2',
            'link' => '/admin/dashboard',
        ],

        [
            'title' => 'Institute',
            'submenu_id' => 'instituteSubmenu',
            'submenu' => [
                [
                    'title' => 'Employees',
                    'link' => '/admin/institute/employees',
                ],
                [
                    'title' => 'Department',
                    'link' => '/admin/institute/department',
                ],
                [
                    'title' => 'Teachers',
                    'link' => '/admin/institute/teacher',
                ],
            ],
        ],

        [
            'title' => 'SIS',
            'submenu_id' => 'SISSubmenu',
            'submenu' => [
                [
                    'title' => 'Students',
                    'link' => '/admin/sis/student',
                ],
                [
                    'title' => 'Courses',
                    'link' => '/admin/sis/courses',
                ],
            ],
        ],

        [
            'title' => 'Enrollment',
            'submenu_id' => 'enrollmentSubmenu',
            'submenu' => [
                [
                    'title' => 'Dashboard',
                    'link' => '/admin/enrollment/dashboard',
                ],
                [
                    'title' => 'Add',
                    'link' => '/admin/enrollment/add',
                ],
            ],
        ],

        [
            'title' => 'Attendance',
            'submenu_id' => 'attendanceSubmenu',
            'submenu' => [
                [
                    'title' => 'Dashboard',
                    'link' => '/admin/attendance/dashboard',
                ],
                [
                    'title' => 'Approved',
                    'link' => '/admin/attendance/student/approved',
                ],
            ],
        ],

        [
            'title' => 'Examination',
            'submenu_id' => 'examSubmenu',
            'submenu' => [
                [
                    'title' => 'Add',
                    'link' => '/admin/examination/add',
                ],
                [
                    'title' => 'Results',
                    'link' => '/admin/examination/results',
                ],
            ],
        ],

        [
            'title' => 'Schedule',
            'submenu_id' => 'scheduleSubmenu',
            'submenu' => [
                [
                    'title' => 'Schedule',
                    'link' => '/admin/schedule/index',
                ],
            ],
        ],

        [
            'title' => 'Register',
            'link' => '/admin/register',
        ],

        [
            'title' => 'Report',
            'submenu_id' => 'reportSubmenu',
            'submenu' => [
                [
                    'title' => 'Dashboard',
                    'link' => '/admin/report/index',
                ],
            ],
        ],
    ],

    'teacher' => [

        [
            'title' => 'Dashboard',
            'icon' => 'bi bi-speedometer2',
            'link' => '/teacher/dashboard',
        ],

        [
            'title' => 'Attendance',
            'submenu_id' => 'attendanceSubmenu',
            'submenu' => [
                [
                    'title' => 'Dashboard',
                    'link' => '/teacher/attendance/dashboard',
                ],
                [
                    'title' => 'Approved',
                    'link' => '/teacher/attendance/student/approved',
                ],
            ],
        ],

        [
            'title' => 'Examination',
            'submenu_id' => 'examSubmenu',
            'submenu' => [
                [
                    'title' => 'Add',
                    'link' => '/teacher/examination/add',
                ],
                [
                    'title' => 'Results',
                    'link' => '/teacher/examination/results',
                ],
            ],
        ],

        [
            'title' => 'Schedule',
            'submenu_id' => 'scheduleSubmenu',
            'submenu' => [
                [
                    'title' => 'Schedule',
                    'link' => '#',
                ],
            ],
        ],

        [
            'title' => 'Sign Out',
            'link' => '/auth/signout',
        ],
    ],

];
