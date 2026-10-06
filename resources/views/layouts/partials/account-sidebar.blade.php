{{-- resources/views/layouts/partials/account-sidebar.blade.php --}}

<aside
    id="account-sidebar"
    class="bg-white border-end z-0">

    <div class="sidebar-inner">

        {{-- =====================================================
             MAIN
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                MAIN
            </div>


            {{-- Dashboard --}}
            <a
                href="{{ url('/admin/dashboard') }}"
                class="sidebar-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dashboard</span>
            </a>

        </div>


        {{-- =====================================================
             INSTITUTE
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                INSTITUTE
            </div>


            {{-- Institute --}}
            <a
                href="{{ url('/admin/institute') }}"
                class="sidebar-link {{ request()->is('admin/institute') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Institute</span>
            </a>


            {{-- Branches --}}
            <a
                href="{{ url('/admin/institute/branches') }}"
                class="sidebar-link {{ request()->is('admin/institute/branches*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i>
                <span>Branches</span>
            </a>


            {{-- Departments --}}
            <a
                href="{{ url('/admin/institute/departments') }}"
                class="sidebar-link {{ request()->is('admin/institute/departments*') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                <span>Departments</span>
            </a>


            {{-- Positions --}}
            <a
                href="{{ url('/admin/institute/positions') }}"
                class="sidebar-link {{ request()->is('admin/institute/positions*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>Positions</span>
            </a>


            {{-- Rooms --}}
            <a
                href="{{ url('/admin/institute/rooms') }}"
                class="sidebar-link {{ request()->is('admin/institute/rooms*') ? 'active' : '' }}">
                <i class="bi bi-door-open"></i>
                <span>Rooms</span>
            </a>

        </div>


        {{-- =====================================================
             ACADEMIC
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                ACADEMIC
            </div>


            {{-- Academic Years --}}
            <a
                href="{{ url('/admin/academic-years') }}"
                class="sidebar-link {{ request()->is('admin/academic-years*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i>
                <span>Academic Years</span>
            </a>


            {{-- Classes --}}
            <a
                href="{{ url('/admin/classes') }}"
                class="sidebar-link {{ request()->is('admin/classes*') ? 'active' : '' }}">
                <i class="bi bi-easel"></i>
                <span>Classes</span>
            </a>


            {{-- Subjects --}}
            <a
                href="{{ url('/admin/subjects') }}"
                class="sidebar-link {{ request()->is('admin/subjects*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Subjects</span>
            </a>


            {{-- Courses --}}
            <a
                href="{{ url('/admin/courses') }}"
                class="sidebar-link {{ request()->is('admin/courses*') ? 'active' : '' }}">
                <i class="bi bi-journals"></i>
                <span>Courses</span>
            </a>

        </div>


        {{-- =====================================================
             PEOPLE
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                PEOPLE
            </div>


            {{-- Employees --}}
            <a
                href="{{ url('/admin/employees') }}"
                class="sidebar-link {{ request()->is('admin/employees*') ? 'active' : '' }}">
                <i class="bi bi-person-vcard"></i>
                <span>Employees</span>
            </a>


            {{-- Teachers --}}
            <a
                href="{{ url('/admin/teachers') }}"
                class="sidebar-link {{ request()->is('admin/teachers*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i>
                <span>Teachers</span>
            </a>


            {{-- Students --}}
            <a
                href="{{ url('/admin/students') }}"
                class="sidebar-link {{ request()->is('admin/students*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span>Students</span>
            </a>

        </div>


        {{-- =====================================================
             STUDENT MANAGEMENT
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                STUDENT MANAGEMENT
            </div>


            {{-- Enrollment --}}
            <a
                href="{{ url('/admin/enrollments') }}"
                class="sidebar-link {{ request()->is('admin/enrollments*') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i>
                <span>Enrollments</span>
            </a>


            {{-- Attendance --}}
            <a
                href="{{ url('/admin/attendance') }}"
                class="sidebar-link {{ request()->is('admin/attendance*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Attendance</span>
            </a>


            {{-- Scores --}}
            <a
                href="{{ url('/admin/scores') }}"
                class="sidebar-link {{ request()->is('admin/scores*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i>
                <span>Scores</span>
            </a>


            {{-- Results --}}
            <a
                href="{{ url('/admin/results') }}"
                class="sidebar-link {{ request()->is('admin/results*') ? 'active' : '' }}">
                <i class="bi bi-award"></i>
                <span>Results</span>
            </a>

        </div>


        {{-- =====================================================
             FINANCE
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                FINANCE
            </div>


            {{-- Payments --}}
            <a
                href="{{ url('/admin/payments') }}"
                class="sidebar-link {{ request()->is('admin/payments*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i>
                <span>Payments</span>
            </a>


            {{-- Invoices --}}
            <a
                href="{{ url('/admin/invoices') }}"
                class="sidebar-link {{ request()->is('admin/invoices*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i>
                <span>Invoices</span>
            </a>


            {{-- Expenses --}}
            <a
                href="{{ url('/admin/expenses') }}"
                class="sidebar-link {{ request()->is('admin/expenses*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Expenses</span>
            </a>


            {{-- Financial Reports --}}
            <a
                href="{{ url('/admin/reports/finance') }}"
                class="sidebar-link {{ request()->is('admin/reports/finance*') ? 'active' : '' }}">
                <i class="bi bi-graph-up"></i>
                <span>Financial Reports</span>
            </a>

        </div>


        {{-- =====================================================
             USER & ACCESS
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                USER & ACCESS
            </div>


            {{-- Users --}}
            <a
                href="{{ url('/admin/users') }}"
                class="sidebar-link {{ request()->is('admin/users*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i>
                <span>Users</span>
            </a>


            {{-- Roles --}}
            <a
                href="{{ url('/admin/roles') }}"
                class="sidebar-link {{ request()->is('admin/roles*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i>
                <span>Roles</span>
            </a>


            {{-- Permissions --}}
            <a
                href="{{ url('/admin/permissions') }}"
                class="sidebar-link {{ request()->is('admin/permissions*') ? 'active' : '' }}">
                <i class="bi bi-key"></i>
                <span>Permissions</span>
            </a>

        </div>


        {{-- =====================================================
             REPORTS
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                REPORTS
            </div>


            <a
                href="{{ url('/admin/reports') }}"
                class="sidebar-link {{ request()->is('admin/reports') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-bar-graph"></i>
                <span>Reports</span>
            </a>

        </div>


        {{-- =====================================================
             SYSTEM
        ====================================================== --}}
        <div class="sidebar-section">

            <div class="sidebar-heading">
                SYSTEM
            </div>


            <a
                href="{{ url('/admin/settings') }}"
                class="sidebar-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i>
                <span>Settings</span>
            </a>

        </div>

    </div>

</aside>


{{-- =============================================================
     SIDEBAR STYLES
============================================================= --}}
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


    /* Scrollbar */

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


    /* =========================================================
       MOBILE
    ========================================================== */

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


{{-- =============================================================
     SIDEBAR JAVASCRIPT
============================================================= --}}
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


        // Close sidebar when clicking outside on mobile

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