
<?php
// config\navigation.php
return [

    /*
    |--------------------------------------------------------------------------
    | Admin Navigation
    |--------------------------------------------------------------------------
    */

    'admin' => [

        [
            'title' => 'Dashboard',
            'icon' => 'bi bi-speedometer2',
            'link' => '/admin/dashboard',
            'route' => 'admin.dashboard',
        ],

        [
            'title' => 'Institute',
            'icon' => 'bi bi-building',
            'submenu_id' => 'instituteSubmenu',
            'submenu' => [
                [
                    'title' => 'Branches',
                    'icon' => 'bi bi-diagram-3',
                    'link' => '/admin/institute/branches',
                    'route' => 'admin.institute.branches',
                ],
                [
                    'title' => 'Rooms',
                    'icon' => 'bi bi-door-open',
                    'link' => '/admin/institute/rooms',
                    'route' => 'admin.institute.rooms',
                ],
                [
                    'title' => 'Positions',
                    'icon' => 'bi bi-person-badge',
                    'link' => '/admin/institute/positions',
                    'route' => 'admin.institute.positions',
                ],
            ],
        ],

        [
            'title' => 'People',
            'icon' => 'bi bi-people',
            'submenu_id' => 'peopleSubmenu',
            'submenu' => [
                [
                    'title' => 'Employees',
                    'icon' => 'bi bi-person-vcard',
                    'link' => '/admin/people/employees',
                    'route' => 'admin.people.employees',
                ],
                [
                    'title' => 'Teachers',
                    'icon' => 'bi bi-person-workspace',
                    'link' => '/admin/people/teachers',
                    'route' => 'admin.people.teachers',
                ],
                [
                    'title' => 'Students',
                    'icon' => 'bi bi-mortarboard',
                    'link' => '/admin/people/students',
                    'route' => 'admin.people.students',
                ],
            ],
        ],

        [
            'title' => 'Academic',
            'icon' => 'bi bi-book',
            'submenu_id' => 'academicSubmenu',
            'submenu' => [
                [
                    'title' => 'Academic Years',
                    'icon' => 'bi bi-calendar-event',
                    'link' => '/admin/academic/academic-years',
                    'route' => 'admin.academic.academic-years',
                ],
                [
                    'title' => 'Classes',
                    'icon' => 'bi bi-door-open',
                    'link' => '/admin/academic/academic-classes',
                    'route' => 'admin.academic.academic-classes',
                ],
                [
                    'title' => 'Subjects',
                    'icon' => 'bi bi-journal-bookmark',
                    'link' => '/admin/academic/academic-subjects',
                    'route' => 'admin.academic.academic-subjects',
                ],
                [
                    'title' => 'Courses',
                    'icon' => 'bi bi-book',
                    'link' => '/admin/academic/academic-courses',
                    'route' => 'admin.academic.academic-courses',
                ],
            ],
        ],

        [
            'title' => 'Registration',
            'icon' => 'bi bi-person-plus',
            'submenu_id' => 'registrationSubmenu',
            'submenu' => [
                [
                    'title' => 'Student Registration',
                    'icon' => 'bi bi-person-plus',
                    'link' => '/admin/registrations/students',
                    'route' => 'admin.registrations.students.index',
                ],
                [
                    'title' => 'Employee Registration',
                    'icon' => 'bi bi-person-badge',
                    'link' => '/admin/registrations/employees',
                    'route' => 'admin.registrations.employees.index',
                ],
            ],
        ],
        [
            'title' => 'Roles & Permissions',
            'icon' => 'bi bi-person-plus',
            'submenu_id' => 'rpSubmenu',
            'submenu' => [
                [
                    'title' => 'Users',
                    'icon' => 'bi bi-person-plus',
                    'link' => '/admin/users',
                    'route' => 'admin.users.index',
                ],
                [
                    'title' => 'Roles',
                    'icon' => 'bi bi-person-badge',
                    'link' => '/admin/users/roles',
                    'route' => 'admin.roles.index',
                ],
                [
                    'title' => 'Permissions',
                    'icon' => 'bi bi-key',
                    'link' => '/admin/users/permissions',
                    'route' => 'admin.permissions.index',
                ],
            ],
        ],

        // Future modules: add routes before enabling these menu items.

    ],


    /*
    |--------------------------------------------------------------------------
    | Account Navigation
    |--------------------------------------------------------------------------
    */

    'account' => [

        [
            'title' => 'Dashboard',
            'icon' => 'bi bi-speedometer2',
            'link' => '/account/dashboard',
            'route' => 'account.dashboard',
        ],

        [
            'title' => 'Institute',
            'icon' => 'bi bi-building',
            'submenu_id' => 'accountInstituteSubmenu',
            'submenu' => [
                [
                    'title' => 'Branches',
                    'icon' => 'bi bi-diagram-3',
                    'link' => '/account/institute/branches',
                    'route' => 'account.institute.branches',
                ],
                [
                    'title' => 'Rooms',
                    'icon' => 'bi bi-door-open',
                    'link' => '/account/institute/rooms',
                    'route' => 'account.institute.rooms',
                ],
                [
                    'title' => 'Positions',
                    'icon' => 'bi bi-person-badge',
                    'link' => '/account/institute/positions',
                    'route' => 'account.institute.positions',
                ],
            ],
        ],

        [
            'title' => 'People',
            'icon' => 'bi bi-people',
            'submenu_id' => 'accountPeopleSubmenu',
            'submenu' => [
                [
                    'title' => 'Employees',
                    'link' => '/account/people/employees',
                    'route' => 'account.people.employees',
                ],
                [
                    'title' => 'Teachers',
                    'link' => '/account/people/teachers',
                    'route' => 'account.people.teachers',
                ],
                [
                    'title' => 'Students',
                    'link' => '/account/people/students',
                    'route' => 'account.people.students',
                ],
            ],
        ],

        [
            'title' => 'Academic',
            'icon' => 'bi bi-book',
            'submenu_id' => 'accountAcademicSubmenu',
            'submenu' => [
                [
                    'title' => 'Academic Years',
                    'link' => '/account/academic/academic-years',
                    'route' => 'account.academic.academic-years',
                ],
                [
                    'title' => 'Classes',
                    'link' => '/account/academic/academic-classes',
                    'route' => 'account.academic.academic-classes',
                ],
                [
                    'title' => 'Subjects',
                    'link' => '/account/academic/academic-subjects',
                    'route' => 'account.academic.academic-subjects',
                ],
                [
                    'title' => 'Courses',
                    'link' => '/account/academic/academic-courses',
                    'route' => 'account.academic.academic-courses',
                ],
            ],
        ],

        [
            'title' => 'Registration',
            'icon' => 'bi bi-person-plus',
            'submenu_id' => 'accountRegistrationSubmenu',
            'submenu' => [
                [
                    'title' => 'Student Registration',
                    'link' => '/account/registrations/students',
                    'route' => 'account.registrations.students.index',
                ],
                [
                    'title' => 'Employee Registration',
                    'link' => '/account/registrations/employees',
                    'route' => 'account.registrations.employees.index',
                ],
            ],
        ],

    ],


    /*
    |--------------------------------------------------------------------------
    | Teacher Navigation
    |--------------------------------------------------------------------------
    |
    | Teacher routes have not been registered in the current route:list.
    | Add them when the Teacher module is implemented.
    |
    */

    'teacher' => [],

];
?>