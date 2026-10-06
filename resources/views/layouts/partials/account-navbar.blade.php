{{-- resources/views/layouts/partials/account-navbar.blade.php --}}

<nav
    class="navbar navbar-expand-lg bg-white border-bottom shadow-sm sticky-top"
    id="account-navbar">
    <div class="container-fluid px-3 px-lg-4">

        {{-- Sidebar Toggle --}}
        <button
            class="btn btn-outline-secondary d-lg-none me-2"
            type="button"
            id="sidebarToggle"
            aria-label="Toggle sidebar">
            <i class="bi bi-list fs-5"></i>
        </button>
        {{-- Brand --}}
        <div class="me-6 me-lg-3 d-flex align-items-center">
            <a
                href="{{ url('/admin/dashboard') }}"
                class="navbar-brand d-flex align-items-center gap-2">

                <img
                    src="{{ asset('images/icon.webp') }}"
                    alt="3EONE"
                    width="38"
                    height="38"
                    class="rounded">

                <div class="d-none d-sm-block">
                    <div class="fw-bold lh-1">
                        3EONE
                    </div>

                    <small class="text-muted">
                        Administration
                    </small>
                </div>

            </a>
        </div>
        <div class="d-flex justify-content-between align-items-center flex-grow-1 ms-3">
            <div class="d-flex w-50" style="height: 45px">

                {{-- Search --}}
                <form
                    class="d-flex mx-lg-4 my-3 my-lg-0 flex-grow-1 hiegth"
                    role="search"
                    action="{{ url()->current() }}"
                    method="GET">
                    <div class="input-group">

                        <span class="input-group-text bg-light">
                            <i class="bi bi-search"></i>
                        </span>

                        <input
                            type="search"
                            name="q"
                            class="form-control bg-light border-start-0"
                            placeholder="Search..."
                            value="{{ request('q') }}"
                            autocomplete="off">

                    </div>
                </form>
            </div>
            <div class="d-flex align-items-center ">
                <div>
                    {{-- Right Side --}}
                    <ul class="navbar-nav ms-auto align-items-lg-center">

                        {{-- Notifications --}}
                        <li class="nav-item dropdown">

                            <a
                                href="#"
                                class="nav-link position-relative px-3"
                                id="notificationDropdown"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false">
                                <i class="bi bi-bell fs-5"></i>

                                @if(isset($notificationCount) && $notificationCount > 0)
                                <span
                                    class="position-absolute top-0 start-75 translate-middle badge rounded-pill bg-danger">
                                    {{ $notificationCount > 99 ? '99+' : $notificationCount }}
                                </span>
                                @endif
                            </a>


                            <ul
                                class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                                aria-labelledby="notificationDropdown"
                                style="min-width: 300px;">

                                <li>
                                    <h6 class="dropdown-header">
                                        Notifications
                                    </h6>
                                </li>

                                @if(isset($notifications) && $notifications->count())

                                @foreach($notifications as $notification)

                                <li>
                                    <a
                                        href="{{ $notification->url ?? '#' }}"
                                        class="dropdown-item py-2">
                                        <div class="d-flex gap-2">

                                            <i
                                                class="{{ $notification->icon ?? 'bi bi-info-circle' }} text-primary"></i>

                                            <div>
                                                <div class="small fw-semibold">
                                                    {{ $notification->title }}
                                                </div>

                                                @if(isset($notification->message))
                                                <div class="small text-muted">
                                                    {{ $notification->message }}
                                                </div>
                                                @endif
                                            </div>

                                        </div>
                                    </a>
                                </li>

                                @endforeach

                                @else

                                <li>
                                    <div class="dropdown-item-text text-center py-4">

                                        <i
                                            class="bi bi-bell-slash text-muted fs-3"></i>

                                        <div class="small text-muted mt-2">
                                            No notifications
                                        </div>

                                    </div>
                                </li>

                                @endif

                            </ul>

                        </li>
                </div>
                <div>
                    {{-- User Menu --}}
                    <li class="nav-item dropdown ms-lg-2 list-unstyled">

                        <a
                            href="#"
                            class="nav-link dropdown-toggle d-flex align-items-center gap-2"
                            id="userDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">

                            @php
                            $user = auth()->user();

                            $displayName =
                            $user?->display_name
                            ?? $user?->full_name
                            ?? $user?->username
                            ?? 'User';

                            $profileImage =
                            $user?->profile_image
                            ?? 'images/default-user.png';
                            @endphp


                            <img
                                src="{{ asset($profileImage) }}"
                                alt="{{ $displayName }}"
                                width="38"
                                height="38"
                                class="rounded-circle border"
                                style="object-fit: cover;">


                            <div class="d-none d-md-block text-start">

                                <div class="fw-semibold small">
                                    {{ $displayName }}
                                </div>

                                <div class="text-muted small">
                                    {{ $user?->role?->role_name ?? 'Admin' }}
                                </div>

                            </div>

                        </a>
                        <ul
                            class="dropdown-menu dropdown-menu-end shadow-sm border-0"
                            aria-labelledby="userDropdown">

                            <li>
                                <h6 class="dropdown-header">
                                    Account
                                </h6>
                            </li>


                            {{-- Profile --}}
                            <li>
                                <a
                                    class="dropdown-item"
                                    href="{{ url('/admin/profile') }}">
                                    <i class="bi bi-person me-2"></i>
                                    My Profile
                                </a>
                            </li>


                            {{-- Settings --}}
                            <li>
                                <a
                                    class="dropdown-item"
                                    href="{{ url('/admin/settings') }}">
                                    <i class="bi bi-gear me-2"></i>
                                    Settings
                                </a>
                            </li>


                            <li>
                                <hr class="dropdown-divider">
                            </li>


                            {{-- Logout --}}
                            <li>

                                <form action="{{ url('/auth/signout') }}" method="POST">

                                    @csrf

                                    <button
                                        type="submit"
                                        class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        Sign Out
                                    </button>

                                </form>

                            </li>
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </div>
</nav>