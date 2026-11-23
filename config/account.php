<?php

// config/account.php

return [
    'sidebar' => [
        [
            'title' => 'MAIN',
            'items' => [
                [
                    'label' => 'Dashboard',
                    'url' => '/account/dashboard',
                    'icon' => 'bi-speedometer2',
                    'route' => 'account.dashboard',
                ],
            ],
        ],

        [
            'title' => 'INSTITUTE',
            'items' => [
                [
                    'label' => 'Branches',
                    'url' => '/account/institute/branches',
                    'icon' => 'bi-diagram-3',
                    'route' => 'account.institute.branches*',
                ],
                [
                    'label' => 'Departments',
                    'url' => '/account/institute/departments',
                    'icon' => 'bi-grid',
                    'route' => 'account.institute.departments.*',
                ],
                [
                    'label' => 'Positions',
                    'url' => '/account/institute/positions',
                    'icon' => 'bi-person-badge',
                    'route' => 'account.institute.positions*',
                ],
                [
                    'label' => 'Rooms',
                    'url' => '/account/institute/rooms',
                    'icon' => 'bi-door-open',
                    'route' => 'account.institute.rooms*',
                ],
            ],
        ],

        [
            'title' => 'ACADEMIC',
            'items' => [
                [
                    'label' => 'Academic Years',
                    'url' => '/account/academic/academic-years',
                    'icon' => 'bi-calendar3',
                    'route' => 'account.academic.academic-years*',
                ],
                [
                    'label' => 'Classes',
                    'url' => '/account/academic/academic-classes',
                    'icon' => 'bi-easel',
                    'route' => 'account.academic.academic-classes*',
                ],
                [
                    'label' => 'Subjects',
                    'url' => '/account/academic/academic-subjects',
                    'icon' => 'bi-book',
                    'route' => 'account.academic.academic-subjects*',
                ],
                [
                    'label' => 'Courses',
                    'url' => '/account/academic/academic-courses',
                    'icon' => 'bi-journals',
                    'route' => 'account.academic.academic-courses*',
                ],
            ],
        ],

        [
            'title' => 'PEOPLE',
            'items' => [
                [
                    'label' => 'Employees',
                    'url' => '/account/people/employees',
                    'icon' => 'bi-person-vcard',
                    'route' => 'account.people.employees*',
                ],
                [
                    'label' => 'Teachers',
                    'url' => '/account/people/teachers',
                    'icon' => 'bi-person-workspace',
                    'route' => 'account.people.teachers*',
                ],
                [
                    'label' => 'Students',
                    'url' => '/account/people/students',
                    'icon' => 'bi-people',
                    'route' => 'account.people.students*',
                ],
            ],
        ],

        [
            'title' => 'REGISTRATION',
            'items' => [
                [
                    'label' => 'Student Registration',
                    'url' => '/account/registrations/students',
                    'icon' => 'bi-person-plus',
                    'route' => 'account.registrations.students.*',
                ],
                [
                    'label' => 'Employee Registration',
                    'url' => '/account/registrations/employees',
                    'icon' => 'bi-person-plus',
                    'route' => 'account.registrations.employees.*',
                ],
            ],
        ],

        [
            'title' => 'STUDENT MANAGEMENT',
            'items' => [
                [
                    'label' => 'Enrollments',
                    'url' => '/account/enrollments',
                    'icon' => 'bi-person-plus',
                    'route' => 'account.enrollments.*',
                ],
                [
                    'label' => 'Attendance',
                    'url' => '/account/attendance',
                    'icon' => 'bi-calendar-check',
                    'route' => 'account.attendance.*',
                ],
                [
                    'label' => 'Scores',
                    'url' => '/account/scores',
                    'icon' => 'bi-bar-chart',
                    'route' => 'account.scores.*',
                ],
                [
                    'label' => 'Results',
                    'url' => '/account/results',
                    'icon' => 'bi-award',
                    'route' => 'account.results.*',
                ],
            ],
        ],

        [
            'title' => 'FINANCE',
            'items' => [
                [
                    'label' => 'Payments',
                    'url' => '/account/payments',
                    'icon' => 'bi-cash-stack',
                    'route' => 'account.payments.*',
                ],
                [
                    'label' => 'Invoices',
                    'url' => '/account/invoices',
                    'icon' => 'bi-receipt',
                    'route' => 'account.invoices.*',
                ],
                [
                    'label' => 'Expenses',
                    'url' => '/account/expenses',
                    'icon' => 'bi-wallet2',
                    'route' => 'account.expenses.*',
                ],
                [
                    'label' => 'Financial Reports',
                    'url' => '/account/reports/finance',
                    'icon' => 'bi-graph-up',
                    'route' => 'account.reports.finance.*',
                ],
            ],
        ],

        [
            'title' => 'USER & ACCESS',
            'items' => [
                [
                    'label' => 'Users',
                    'url' => '/account/users',
                    'icon' => 'bi-person-gear',
                    'route' => 'account.users.*',
                ],
                [
                    'label' => 'Roles',
                    'url' => '/account/roles',
                    'icon' => 'bi-shield-lock',
                    'route' => 'account.roles.*',
                ],
                [
                    'label' => 'Permissions',
                    'url' => '/account/permissions',
                    'icon' => 'bi-key',
                    'route' => 'account.permissions.*',
                ],
            ],
        ],

        [
            'title' => 'REPORTS & IMPORT',
            'items' => [
                [
                    'label' => 'Reports',
                    'url' => '/account/reports',
                    'icon' => 'bi-file-earmark-bar-graph',
                    'route' => 'account.reports',
                ],
                [
                    'label' => 'Imports',
                    'url' => '/account/imports',
                    'icon' => 'bi-file-earmark-bar-graph',
                    'route' => 'account.imports',
                ],
            ],

        ],

        [
            'title' => 'SYSTEM',
            'items' => [
                [
                    'label' => 'Settings',
                    'url' => '/account/settings',
                    'icon' => 'bi-gear',
                    'route' => 'account.settings.*',
                ],
            ],
        ],
    ],
];
