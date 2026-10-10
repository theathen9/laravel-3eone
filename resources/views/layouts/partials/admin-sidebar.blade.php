{{-- resources/views/layouts/partials/admin-sidebar.blade.php --}}

<aside id="admin-sidebar" class="bg-white border-end z-1">
    <div class="sidebar-inner">
        @foreach ($sidebarSections as $section)
        <div class="sidebar-section">
            <div class="sidebar-heading">
                {{ $section['title'] }}
            </div>

            @foreach ($section['items'] as $item)
            @php
            $routePattern = $item['route'] ?? null;

            $isActive = $routePattern
            && request()->routeIs($routePattern);
            @endphp

            <a
                href="{{ url($item['url']) }}"
                class="sidebar-link {{ $isActive ? 'active' : '' }}"
                @if ($isActive) aria-current="page" @endif>
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