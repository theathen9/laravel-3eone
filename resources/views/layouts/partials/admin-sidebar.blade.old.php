{{-- resources/views/layouts/partials/admin-sidebar.blade.php --}}

@php
$sidebarSections = [
[
'title' => 'MAIN',
'items' => [
[
'label' => 'Dashboard',
'url' => '/admin/dashboard',
'icon' => 'bi-speedometer2',
'route' => 'admin/dashboard',
],
],
],

[
'title' => 'INSTITUTE',
'items' => [
[
'label' => 'Institute',
'url' => '/admin/institute',
'icon' => 'bi-building',
'route' => 'admin/institute',
],
[
'label' => 'Branches',
'url' => '/admin/institute/branches',
'icon' => 'bi-diagram-3',
'route' => 'admin/institute/branches*',
],
[
'label' => 'Departments',
'url' => '/admin/institute/departments',
'icon' => 'bi-grid',
'route' => 'admin/institute/departments*',
],
[
'label' => 'Positions',
'url' => '/admin/institute/positions',
'icon' => 'bi-person-badge',
'route' => 'admin/institute/positions*',
],
[
'label' => 'Rooms',
'url' => '/admin/institute/rooms',
'icon' => 'bi-door-open',
'route' => 'admin/institute/rooms*',
],
],
],

[
'title' => 'ACADEMIC',
'items' => [
[
'label' => 'Academic Years',
'url' => '/admin/academic-years',
'icon' => 'bi-calendar3',
'route' => 'admin/academic-years*',
],
[
'label' => 'Classes',
'url' => '/admin/classes',
'icon' => 'bi-easel',
'route' => 'admin/classes*',
],
[
'label' => 'Subjects',
'url' => '/admin/subjects',
'icon' => 'bi-book',
'route' => 'admin/subjects*',
],
[
'label' => 'Courses',
'url' => '/admin/courses',
'icon' => 'bi-journals',
'route' => 'admin/courses*',
],
],
],

[
'title' => 'PEOPLE',
'items' => [
[
'label' => 'Employees',
'url' => '/admin/employees',
'icon' => 'bi-person-vcard',
'route' => 'admin/employees*',
],
[
'label' => 'Teachers',
'url' => '/admin/teachers',
'icon' => 'bi-person-workspace',
'route' => 'admin/teachers*',
],
[
'label' => 'Students',
'url' => '/admin/students',
'icon' => 'bi-people',
'route' => 'admin/students*',
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
'route' => 'admin/registrations/students*',
],
[
'label' => 'Employee Registration',
'url' => '/admin/registrations/employees',
'icon' => 'bi-person-plus',
'route' => 'admin/registrations/employees*',
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
'route' => 'admin/enrollments*',
],
[
'label' => 'Attendance',
'url' => '/admin/attendance',
'icon' => 'bi-calendar-check',
'route' => 'admin/attendance*',
],
[
'label' => 'Scores',
'url' => '/admin/scores',
'icon' => 'bi-bar-chart',
'route' => 'admin/scores*',
],
[
'label' => 'Results',
'url' => '/admin/results',
'icon' => 'bi-award',
'route' => 'admin/results*',
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
'route' => 'admin/payments*',
],
[
'label' => 'Invoices',
'url' => '/admin/invoices',
'icon' => 'bi-receipt',
'route' => 'admin/invoices*',
],
[
'label' => 'Expenses',
'url' => '/admin/expenses',
'icon' => 'bi-wallet2',
'route' => 'admin/expenses*',
],
[
'label' => 'Financial Reports',
'url' => '/admin/reports/finance',
'icon' => 'bi-graph-up',
'route' => 'admin/reports/finance*',
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
'route' => 'admin/users*',
],
[
'label' => 'Roles',
'url' => '/admin/roles',
'icon' => 'bi-shield-lock',
'route' => 'admin/roles*',
],
[
'label' => 'Permissions',
'url' => '/admin/permissions',
'icon' => 'bi-key',
'route' => 'admin/permissions*',
],
],
],

[
'title' => 'REPORTS',
'items' => [
[
'label' => 'Reports',
'url' => '/admin/reports',
'icon' => 'bi-file-earmark-bar-graph',
'route' => 'admin/reports',
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
'route' => 'admin/settings*',
],
],
],
];
@endphp


<aside
    id="admin-sidebar"
    class="bg-white border-end z-0">

    <div class="sidebar-inner">

        @foreach ($sidebarSections as $section)

        <div class="sidebar-section">

            <div class="sidebar-heading">
                {{ $section['title'] }}
            </div>

            @foreach ($section['items'] as $item)

            <a
                href="{{ url($item['url']) }}"
                class="sidebar-link {{ request()->is($item['route']) ? 'active' : '' }}">
                <i class="bi {{ $item['icon'] }}"></i>
                <span>{{ $item['label'] }}</span>
            </a>

            @endforeach

        </div>

        @endforeach

    </div>

</aside>


<style>
    #admin-sidebar {
        width: 260px;
        min-width: 260px;
        height: calc(100vh - 65px);
        position: sticky;
        top: 65px;
        overflow-y: auto;
        transition: all 0.25s ease;
        z-index: 1020;
    }

    .sidebar-inner {
        padding: 1rem 0.75rem;
    }

    .sidebar-section {
        margin-bottom: 1.25rem;
    }

    .sidebar-heading {
        padding: 0.5rem 0.75rem;
        margin-bottom: 0.25rem;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        color: #6c757d;
    }

    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        width: 100%;
        padding: 0.65rem 0.75rem;
        color: #495057;
        text-decoration: none;
        border-radius: 0.5rem;
        font-size: 0.9rem;
        font-weight: 500;
        transition:
            background-color 0.15s ease,
            color 0.15s ease;
    }

    .sidebar-link i {
        width: 20px;
        text-align: center;
        font-size: 1rem;
    }

    .sidebar-link:hover {
        color: #0d6efd;
        background-color: #f1f5ff;
    }

    .sidebar-link.active {
        color: #0d6efd;
        background-color: #e9f0ff;
        font-weight: 600;
    }

    .sidebar-link.active i {
        color: #0d6efd;
    }

    #admin-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    #admin-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #admin-sidebar::-webkit-scrollbar-thumb {
        background: #dee2e6;
        border-radius: 10px;
    }

    @media (max-width: 991.98px) {

        #admin-sidebar {
            position: fixed;
            top: 65px;
            left: -270px;
            height: calc(100vh - 65px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        #admin-sidebar.show {
            left: 0;
        }

        #admin-content {
            width: 100%;
        }

    }
</style>


<script>
    document.addEventListener('DOMContentLoaded', function() {

        const sidebar = document.getElementById('admin-sidebar');
        const toggle = document.getElementById('sidebarToggle');

        if (!sidebar || !toggle) {
            return;
        }

        toggle.addEventListener('click', function() {
            sidebar.classList.toggle('show');
        });

        document.addEventListener('click', function(event) {

            if (window.innerWidth >= 992) {
                return;
            }

            if (
                sidebar.classList.contains('show') &&
                !sidebar.contains(event.target) &&
                !toggle.contains(event.target)
            ) {
                sidebar.classList.remove('show');
            }

        });

    });
</script>