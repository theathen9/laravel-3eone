{{-- resources/views/layouts/admin.blade.php --}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Account | 3EONE')
    </title>

    {{-- Favicon --}}
    <link
        rel="icon"
        type="image/webp"
        href="{{ asset('images/icon.webp') }}">

    {{-- Bootstrap --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
        rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
        rel="stylesheet">

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{-- Flatpickr --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    {{-- Application CSS / JS --}}
    @vite([
    'resources/css/app.css',
    'resources/js/app.js'
    ])

    @stack('styles')
</head>

<body>

    {{-- =========================================================
         ACCOUNT NAVIGATION
    ========================================================== --}}
    @include('layouts.partials.account-navbar')


    <div class="d-flex">

        {{-- =====================================================
             SIDEBAR
        ====================================================== --}}
        @include('layouts.partials.account-sidebar')


        {{-- =====================================================
             MAIN CONTENT
        ====================================================== --}}
        <main
            id="account-content"
            class="flex-grow-1">

            {{-- Page Header --}}
            @hasSection('page-header')
            <div class="container-fluid px-4 pt-4">
                @yield('page-header')
            </div>
            @endif


            {{-- Flash Messages --}}
            <div class="container-fluid px-4 pt-3">

                @if (session('success'))
                <div
                    class="alert alert-success alert-dismissible fade show"
                    role="alert">
                    <i class="bi bi-check-circle me-2"></i>
                    {{ session('success') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                @endif


                @if (session('error'))
                <div
                    class="alert alert-danger alert-dismissible fade show"
                    role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                @endif


                @if (session('warning'))
                <div
                    class="alert alert-warning alert-dismissible fade show"
                    role="alert">
                    <i class="bi bi-exclamation-circle me-2"></i>
                    {{ session('warning') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                @endif


                @if (session('info'))
                <div
                    class="alert alert-info alert-dismissible fade show"
                    role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    {{ session('info') }}

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                @endif

            </div>


            {{-- =================================================
                 PAGE CONTENT
            ================================================== --}}
            <div class="container-fluid px-4 py-4">

                @yield('content')

            </div>

        </main>

    </div>


    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    @hasSection('footer')
    @yield('footer')
    @else
    <footer class="text-center text-muted py-3">
        <small>
            &copy; {{ date('Y') }}
            {{ config('app.name', '3EONE') }}.
            All rights reserved.
        </small>
    </footer>
    @endif


    {{-- =========================================================
         MODALS
    ========================================================== --}}
    @stack('modals')


    {{-- =========================================================
         JAVASCRIPT
    ========================================================== --}}

    {{-- Bootstrap --}}
    <!-- <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js">
    </script> -->

    {{-- Flatpickr --}}
    <script
        src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @stack('scripts')

</body>

</html>