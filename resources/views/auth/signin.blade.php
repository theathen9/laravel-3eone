@extends('layouts.guest')

@section('title', 'Sign in | 3EONE')

@section('content')

<div class="background-image relative flex min-h-screen w-full items-center justify-center overflow-hidden bg-slate-950 px-4 py-10">

    {{-- Background decoration --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -left-32 -top-32 h-96 w-96 rounded-full bg-blue-600/20 blur-3xl"></div>
        <div class="absolute -bottom-32 -right-32 h-96 w-96 rounded-full bg-indigo-600/20 blur-3xl"></div>
    </div>

    {{-- Login Card --}}
    <div class="relative z-10 w-full max-w-md">

        <div class="overflow-hidden rounded-2xl border border-white/20 bg-white shadow-2xl">

            <div class="px-6 py-9 sm:px-10">

                {{-- Logo --}}
                <div class="mb-8 text-center">

                    <img
                        src="{{ asset('images/icon.webp') }}"
                        alt="3EONE logo"
                        width="100"
                        height="100"
                        fetchpriority="high"
                        class="mx-auto mb-5 h-24 w-24 rounded-2xl object-cover shadow-lg">

                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900">
                        3EONE
                    </h1>

                    <p class="mt-2 text-sm text-gray-500">
                        Welcome back! Sign in to continue.
                    </p>

                </div>

                {{-- General Error --}}
                @if ($errors->any())
                <div
                    class="mb-6 flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"
                    role="alert">

                    <svg class="mt-0.5 h-5 w-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>

                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                {{-- Login Form --}}
                <form
                    id="loginForm"
                    method="POST"
                    action="{{ route('auth.login') }}"
                    class="space-y-5"
                    autocomplete="on">

                    @csrf

                    {{-- Username --}}
                    <div>
                        <label for="username" class="mb-2 block text-sm font-semibold text-gray-700">
                            Username, email, or ID
                        </label>

                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username') }}"
                            autocomplete="username"
                            placeholder="Enter your username"
                            required
                            autofocus
                            class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-gray-700">
                            Password
                        </label>

                        <input
                            type="password"
                            id="password"
                            name="password"
                            autocomplete="current-password"
                            placeholder="Enter your password"
                            required
                            class="block w-full rounded-xl border border-gray-300 bg-gray-50 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-500/10">

                        @error('password')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    {{-- Submit --}}
                    <button
                        type="submit"
                        id="submitBtn"
                        class="group flex min-h-[48px] w-full items-center justify-center gap-2 rounded-xl bg-blue-600 px-4 py-3 text-sm font-bold uppercase tracking-wide text-white shadow-lg shadow-blue-600/20 transition hover:bg-blue-700 hover:shadow-blue-600/30 focus:outline-none focus:ring-4 focus:ring-blue-500/30 active:scale-[0.99] disabled:cursor-not-allowed disabled:opacity-70">

                        <span id="buttonSpinner" class="hidden">
                            <svg
                                class="h-5 w-5 animate-spin"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                aria-hidden="true">

                                <circle
                                    class="opacity-25"
                                    cx="12"
                                    cy="12"
                                    r="10"
                                    stroke="currentColor"
                                    stroke-width="4" />

                                <path
                                    class="opacity-75"
                                    fill="currentColor"
                                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
                            </svg>
                        </span>

                        <span id="buttonText">Sign in</span>
                    </button>

                </form>

            </div>

            {{-- Footer --}}
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-4 text-center">
                <p class="text-xs text-gray-500">
                    &copy; {{ date('Y') }} 3EONE. All rights reserved.
                </p>
            </div>

        </div>

    </div>

</div>

{{-- Full-screen processing overlay --}}
<div
    id="loginOverlay"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/50 px-4 backdrop-blur-sm"
    aria-hidden="true">

    <div class="w-full max-w-xs rounded-2xl bg-white p-8 text-center shadow-2xl">

        <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-blue-50">

            <svg
                class="h-9 w-9 animate-spin text-blue-600"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                aria-hidden="true">

                <circle
                    class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4" />

                <path
                    class="opacity-75"
                    fill="currentColor"
                    d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z" />
            </svg>

        </div>

        <h3 class="text-lg font-bold text-gray-900">
            Authenticating
        </h3>

        <p class="mt-2 text-sm text-gray-500">
            Please wait while we securely sign you in.
        </p>

        <div class="mt-6 h-1.5 overflow-hidden rounded-full bg-gray-100">
            <div class="h-full w-1/2 animate-pulse rounded-full bg-blue-600"></div>
        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const form = document.getElementById('loginForm');
        const username = document.getElementById('username');
        const password = document.getElementById('password');

        const submitBtn = document.getElementById('submitBtn');
        const buttonText = document.getElementById('buttonText');
        const buttonSpinner = document.getElementById('buttonSpinner');
        const loginOverlay = document.getElementById('loginOverlay');

        if (!form || !submitBtn) return;

        let isSubmitting = false;

        // Username → Password
        username.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                password.focus();
            }
        });

        // Password → Submit
        password.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                form.requestSubmit();
            }
        });

        // Login submission
        form.addEventListener('submit', function(event) {

            if (isSubmitting) {
                event.preventDefault();
                return;
            }

            if (!form.checkValidity()) return;

            isSubmitting = true;

            // Button loading
            submitBtn.disabled = true;
            buttonText.textContent = 'Signing in...';
            buttonSpinner.classList.remove('hidden');

            // Disable inputs
            username.readOnly = true;
            password.readOnly = true;

            // Full-screen processing overlay
            loginOverlay.classList.remove('hidden');
            loginOverlay.classList.add('flex');
            loginOverlay.setAttribute('aria-hidden', 'false');

        });

        // Restore UI when browser restores the page
        window.addEventListener('pageshow', function() {

            isSubmitting = false;

            submitBtn.disabled = false;
            buttonText.textContent = 'Sign in';
            buttonSpinner.classList.add('hidden');

            username.readOnly = false;
            password.readOnly = false;

            loginOverlay.classList.add('hidden');
            loginOverlay.classList.remove('flex');
            loginOverlay.setAttribute('aria-hidden', 'true');

        });

    });
</script>

@endpush