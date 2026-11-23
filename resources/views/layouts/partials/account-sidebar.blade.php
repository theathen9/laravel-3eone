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
                href="{{ url('/account/dashboard') }}"
                class="sidebar-link {{ request()->is('account/dashboard') ? 'active' : '' }}">
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
                href="{{ url('/account/institute') }}"
                class="sidebar-link {{ request()->is('account/institute') ? 'active' : '' }}">
                <i class="bi bi-building"></i>
                <span>Institute</span>
            </a>


            {{-- Branches --}}
            <a
                href="{{ url('/account/institute/branches') }}"
                class="sidebar-link {{ request()->is('account/institute/branches*') ? 'active' : '' }}">
                <i class="bi bi-diagram-3"></i>
                <span>Branches</span>
            </a>


            {{-- Departments --}}
            <a
                href="{{ url('/account/institute/departments') }}"
                class="sidebar-link {{ request()->is('account/institute/departments*') ? 'active' : '' }}">
                <i class="bi bi-grid"></i>
                <span>Departments</span>
            </a>


            {{-- Positions --}}
            <a
                href="{{ url('/account/institute/positions') }}"
                class="sidebar-link {{ request()->is('account/institute/positions*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i>
                <span>Positions</span>
            </a>


            {{-- Rooms --}}
            <a
                href="{{ url('/account/institute/rooms') }}"
                class="sidebar-link {{ request()->is('account/institute/rooms*') ? 'active' : '' }}">
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
                href="{{ url('/account/academic-years') }}"
                class="sidebar-link {{ request()->is('account/academic-years*') ? 'active' : '' }}">
                <i class="bi bi-calendar3"></i>
                <span>Academic Years</span>
            </a>


            {{-- Classes --}}
            <a
                href="{{ url('/account/classes') }}"
                class="sidebar-link {{ request()->is('account/classes*') ? 'active' : '' }}">
                <i class="bi bi-easel"></i>
                <span>Classes</span>
            </a>


            {{-- Subjects --}}
            <a
                href="{{ url('/account/subjects') }}"
                class="sidebar-link {{ request()->is('account/subjects*') ? 'active' : '' }}">
                <i class="bi bi-book"></i>
                <span>Subjects</span>
            </a>


            {{-- Courses --}}
            <a
                href="{{ url('/account/courses') }}"
                class="sidebar-link {{ request()->is('account/courses*') ? 'active' : '' }}">
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
                href="{{ url('/account/employees') }}"
                class="sidebar-link {{ request()->is('account/employees*') ? 'active' : '' }}">
                <i class="bi bi-person-vcard"></i>
                <span>Employees</span>
            </a>


            {{-- Teachers --}}
            <a
                href="{{ url('/account/teachers') }}"
                class="sidebar-link {{ request()->is('account/teachers*') ? 'active' : '' }}">
                <i class="bi bi-person-workspace"></i>
                <span>Teachers</span>
            </a>


            {{-- Students --}}
            <a
                href="{{ url('/account/students') }}"
                class="sidebar-link {{ request()->is('account/students*') ? 'active' : '' }}">
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
                href="{{ url('/account/enrollments') }}"
                class="sidebar-link {{ request()->is('account/enrollments*') ? 'active' : '' }}">
                <i class="bi bi-person-plus"></i>
                <span>Enrollments</span>
            </a>


            {{-- Attendance --}}
            <a
                href="{{ url('/account/attendance') }}"
                class="sidebar-link {{ request()->is('account/attendance*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span>Attendance</span>
            </a>


            {{-- Scores --}}
            <a
                href="{{ url('/account/scores') }}"
                class="sidebar-link {{ request()->is('account/scores*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart"></i>
                <span>Scores</span>
            </a>


            {{-- Results --}}
            <a
                href="{{ url('/account/results') }}"
                class="sidebar-link {{ request()->is('account/results*') ? 'active' : '' }}">
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
                href="{{ url('/account/payments') }}"
                class="sidebar-link {{ request()->is('account/payments*') ? 'active' : '' }}">
                <i class="bi bi-cash-stack"></i>
                <span>Payments</span>
            </a>


            {{-- Invoices --}}
            <a
                href="{{ url('/account/invoices') }}"
                class="sidebar-link {{ request()->is('account/invoices*') ? 'active' : '' }}">
                <i class="bi bi-receipt"></i>
                <span>Invoices</span>
            </a>


            {{-- Expenses --}}
            <a
                href="{{ url('/account/expenses') }}"
                class="sidebar-link {{ request()->is('account/expenses*') ? 'active' : '' }}">
                <i class="bi bi-wallet2"></i>
                <span>Expenses</span>
            </a>


            {{-- Financial Reports --}}
            <a
                href="{{ url('/account/reports/finance') }}"
                class="sidebar-link {{ request()->is('account/reports/finance*') ? 'active' : '' }}">
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
                href="{{ url('/account/users') }}"
                class="sidebar-link {{ request()->is('account/users*') ? 'active' : '' }}">
                <i class="bi bi-person-gear"></i>
                <span>Users</span>
            </a>


            {{-- Roles --}}
            <a
                href="{{ url('/account/roles') }}"
                class="sidebar-link {{ request()->is('account/roles*') ? 'active' : '' }}">
                <i class="bi bi-shield-lock"></i>
                <span>Roles</span>
            </a>


            {{-- Permissions --}}
            <a
                href="{{ url('/account/permissions') }}"
                class="sidebar-link {{ request()->is('account/permissions*') ? 'active' : '' }}">
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
                href="{{ url('/account/reports') }}"
                class="sidebar-link {{ request()->is('account/reports') ? 'active' : '' }}">
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
                href="{{ url('/account/settings') }}"
                class="sidebar-link {{ request()->is('account/settings*') ? 'active' : '' }}">
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
    #account-sidebar {
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

    #account-sidebar::-webkit-scrollbar {
        width: 5px;
    }

    #account-sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    #account-sidebar::-webkit-scrollbar-thumb {
        background: #dee2e6;
        border-radius: 10px;
    }


    /* =========================================================
       MOBILE
    ========================================================== */

    @media (max-width: 991.98px) {

        #account-sidebar {
            position: fixed;

            top: 65px;
            left: -270px;

            height: calc(100vh - 65px);

            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        #account-sidebar.show {
            left: 0;
        }

        #account-content {
            width: 100%;
        }

    }
</style>


{{-- =============================================================
     SIDEBAR JAVASCRIPT
============================================================= --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const sidebar = document.getElementById('account-sidebar');
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