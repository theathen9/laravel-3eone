<?php

// config/admin.php

return [
    'sidebar' => [
        [
            'title' => 'MAIN',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'url' => '/admin/dashboard',
                    'icon' => 'bi-speedometer2',
                    'route' => 'admin.dashboard',
                ],
            ],
        ],

        [
            'title' => 'INSTITUTE',
            'items' => [
                [
                    'label' => 'Branches',
                    'url' => '/admin/institute/branches',
                    'icon' => 'bi-diagram-3',
                    'route' => 'admin.institute.branches*',
                ],
                [
                    'label' => 'Departments',
                    'url' => '/admin/institute/departments',
                    'icon' => 'bi-grid',
                    'route' => 'admin.institute.departments.*',
                ],
                [
                    'label' => 'Positions',
                    'url' => '/admin/institute/positions',
                    'icon' => 'bi-person-badge',
                    'route' => 'admin.institute.positions*',
                ],
                [
                    'label' => 'Rooms',
                    'url' => '/admin/institute/rooms',
                    'icon' => 'bi-door-open',
                    'route' => 'admin.institute.rooms*',
                ],
            ],
        ],

        [
            'title' => 'ACADEMIC',
            'items' => [
                [
                    'label' => 'Academic Years',
                    'url' => '/admin/academic/academic-years',
                    'icon' => 'bi-calendar3',
                    'route' => 'admin.academic.academic-years*',
                ],
                [
                    'label' => 'Classes',
                    'url' => '/admin/academic/academic-classes',
                    'icon' => 'bi-easel',
                    'route' => 'admin.academic.academic-classes*',
                ],
                [
                    'label' => 'Subjects',
                    'url' => '/admin/academic/academic-subjects',
                    'icon' => 'bi-book',
                    'route' => 'admin.academic.academic-subjects*',
                ],
                [
                    'label' => 'Courses',
                    'url' => '/admin/academic/academic-courses',
                    'icon' => 'bi-journals',
                    'route' => 'admin.academic.academic-courses*',
                ],
            ],
        ],

        [
            'title' => 'PEOPLE',
            'items' => [
                [
                    'label' => 'Employees',
                    'url' => '/admin/people/employees',
                    'icon' => 'bi-person-vcard',
                    'route' => 'admin.people.employees*',
                ],
                [
                    'label' => 'Teachers',
                    'url' => '/admin/people/teachers',
                    'icon' => 'bi-person-workspace',
                    'route' => 'admin.people.teachers*',
                ],
                [
                    'label' => 'Students',
                    'url' => '/admin/people/students',
                    'icon' => 'bi-people',
                    'route' => 'admin.people.students*',
                ],
            ],
        ],

        [
            'title' => 'REGISTRATION',
            'items' => [
                [
                    'label' => 'Student Registration',
                    'url' => '/admin/registrations/students',
                    'icon' => 'bi-person-plus',
                    'route' => 'admin.registrations.students.*',
                ],
                [
                    'label' => 'Employee Registration',
                    'url' => '/admin/registrations/employees',
                    'icon' => 'bi-person-plus',
                    'route' => 'admin.registrations.employees.*',
                ],
            ],
        ],

        [
            'title' => 'STUDENT MANAGEMENT',
            'items' => [
                [
                    'label' => 'Enrollments',
                    'url' => '/admin/enrollments',
                    'icon' => 'bi-person-plus',
                    'route' => 'admin.enrollments.*',
                ],
                [
                    'label' => 'Attendance',
                    'url' => '/admin/attendance',
                    'icon' => 'bi-calendar-check',
                    'route' => 'admin.attendance.*',
                ],
                [
                    'label' => 'Scores',
                    'url' => '/admin/scores',
                    'icon' => 'bi-bar-chart',
                    'route' => 'admin.scores.*',
                ],
                [
                    'label' => 'Results',
                    'url' => '/admin/results',
                    'icon' => 'bi-award',
                    'route' => 'admin.results.*',
                ],
            ],
        ],

        [
            'title' => 'FINANCE',
            'items' => [
                [
                    'label' => 'Payments',
                    'url' => '/admin/payments',
                    'icon' => 'bi-cash-stack',
                    'route' => 'admin.payments.*',
                ],
                [
                    'label' => 'Invoices',
                    'url' => '/admin/invoices',
                    'icon' => 'bi-receipt',
                    'route' => 'admin.invoices.*',
                ],
                [
                    'label' => 'Expenses',
                    'url' => '/admin/expenses',
                    'icon' => 'bi-wallet2',
                    'route' => 'admin.expenses.*',
                ],
                [
                    'label' => 'Financial Reports',
                    'url' => '/admin/reports/finance',
                    'icon' => 'bi-graph-up',
                    'route' => 'admin.reports.finance.*',
                ],
            ],
        ],

        [
            'title' => 'USER & ACCESS',
            'items' => [
                [
                    'label' => 'Users',
                    'url' => '/admin/users',
                    'icon' => 'bi-person-gear',
                    'route' => 'admin.users.*',
                ],
                [
                    'label' => 'Roles',
                    'url' => '/admin/roles',
                    'icon' => 'bi-shield-lock',
                    'route' => 'admin.roles.*',
                ],
                [
                    'label' => 'Permissions',
                    'url' => '/admin/permissions',
                    'icon' => 'bi-key',
                    'route' => 'admin.permissions.*',
                ],
            ],
        ],

        [
            'title' => 'REPORTS & IMPORT',
            'items' => [
                [
                    'label' => 'Reports',
                    'url' => '/admin/reports',
                    'icon' => 'bi-file-earmark-bar-graph',
                    'route' => 'admin.reports',
                ],
                [
                    'label' => 'Imports',
                    'url' => '/admin/imports',
                    'icon' => 'bi-file-earmark-bar-graph',
                    'route' => 'admin.imports',
                ],
            ],

        ],

        [
            'title' => 'SYSTEM',
            'items' => [
                [
                    'label' => 'Settings',
                    'url' => '/admin/settings',
                    'icon' => 'bi-gear',
                    'route' => 'admin.settings.*',
                ],
            ],
        ],
    ],
];
