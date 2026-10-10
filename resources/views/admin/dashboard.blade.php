{{-- resources/views/admin/dashboard.blade.php --}}

@extends('layouts.admin')

@section('title', 'Dashboard | 3EONE')

@section('content')
<div class="mx-auto w-full max-w-screen-2xl space-y-6 text-slate-800">

    {{-- Header --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-[#b87d49]">
                3EONE ACADEMY
            </p>
            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Welcome back! Here's your school's overview.
            </p>
        </div>

        <div class="flex items-center gap-2 text-sm text-gray-500">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.8">
                <rect x="3" y="4" width="18" height="17" rx="2" />
                <path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18" />
            </svg>

            <span>{{ now()->format('l, d M Y') }}</span>
        </div>
    </div>

    {{-- Notifications --}}
    @if (session('success'))
    <div role="status" class="flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-100">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
            </svg>
        </span>
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div role="alert" class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
    @endif

    {{-- Welcome Banner --}}
    <section class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-[#bd8755] to-[#d7a778] p-6 text-white shadow-sm sm:p-8">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center rounded-full border border-white/30 bg-white/15 px-3 py-1 text-xs font-semibold tracking-wide">
                ADMINISTRATION
            </span>

            <h2 class="mt-4 text-2xl font-bold sm:text-3xl">
                Welcome to 3E ONE Academy
            </h2>

            <p class="mt-2 max-w-xl text-sm leading-6 text-white/90">
                Manage academic information and school operations from one central place.
            </p>

            <div class="mt-5 flex flex-wrap gap-3">
                @if (Route::has('admin.academic-subjects.index'))
                <a href="{{ route('admin.academic-subjects.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-[#95663c] shadow-sm transition hover:bg-orange-50">
                    Manage Subjects
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                    </svg>
                </a>
                @endif

                @if (Route::has('admin.academic-courses.index'))
                <a href="{{ route('admin.academic-courses.index') }}"
                    class="inline-flex items-center rounded-lg border border-white/40 bg-white/10 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-white/20">
                    View Courses
                </a>
                @endif
            </div>
        </div>

        <div class="pointer-events-none absolute -right-12 -top-20 h-64 w-64 rounded-full border-[36px] border-white/10"></div>
        <div class="pointer-events-none absolute -bottom-24 right-40 h-48 w-48 rounded-full bg-white/10"></div>
    </section>

    {{-- Statistics --}}
    <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Users --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Users</p>
                    <h3 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($totalUsers ?? 0) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">Registered system accounts</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6m3-3h-6" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 h-1 rounded-full bg-blue-50">
                <div class="h-1 w-2/3 rounded-full bg-blue-500"></div>
            </div>
        </div>

        {{-- Students --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Students</p>
                    <h3 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($totalStudents ?? 0) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">Student records</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM4 21v-2a8 8 0 0 1 16 0v2M3 5l9-3 9 3-9 3-9-3Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 h-1 rounded-full bg-emerald-50">
                <div class="h-1 w-3/4 rounded-full bg-emerald-500"></div>
            </div>
        </div>

        {{-- Employees --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Employees</p>
                    <h3 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($totalEmployees ?? 0) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">Teachers and staff</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6m3-3h-6" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 h-1 rounded-full bg-violet-50">
                <div class="h-1 w-1/2 rounded-full bg-violet-500"></div>
            </div>
        </div>

        {{-- Courses --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Courses</p>
                    <h3 class="mt-3 text-3xl font-bold tracking-tight text-slate-900">
                        {{ number_format($totalCourses ?? 0) }}
                    </h3>
                    <p class="mt-2 text-xs text-slate-400">Available course records</p>
                </div>
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-[#b87d49]">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-5 h-1 rounded-full bg-orange-50">
                <div class="h-1 w-2/3 rounded-full bg-[#d1935c]"></div>
            </div>
        </div>
    </section>

    {{-- Main Content --}}
    <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Quick Actions --}}
        <div class="xl:col-span-2">
            <div class="h-full rounded-2xl border border-slate-200 bg-white shadow-sm">
                <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Quick Actions</h2>
                        <p class="mt-1 text-sm text-slate-500">Shortcuts to everyday tasks.</p>
                    </div>
                    <span class="rounded-lg bg-orange-50 px-3 py-1.5 text-xs font-semibold text-[#a66e3e]">
                        Shortcuts
                    </span>
                </div>

                <div class="grid grid-cols-1 gap-3 p-5 sm:grid-cols-2">

                    @php
                    $actions = [
                    [
                    'title' => 'Academic Subjects',
                    'description' => 'Manage subject names and codes',
                    'route' => 'admin.academic-subjects.index',
                    'icon' => 'book',
                    'color' => 'orange',
                    ],
                    [
                    'title' => 'Academic Courses',
                    'description' => 'Organize courses and subjects',
                    'route' => 'admin.academic-courses.index',
                    'icon' => 'course',
                    'color' => 'blue',
                    ],
                    [
                    'title' => 'Academic Years',
                    'description' => 'Manage school academic years',
                    'route' => 'admin.academic-years.index',
                    'icon' => 'calendar',
                    'color' => 'emerald',
                    ],
                    [
                    'title' => 'Students',
                    'description' => 'Review student information',
                    'route' => 'admin.students.index',
                    'icon' => 'users',
                    'color' => 'violet',
                    ],
                    ];
                    @endphp

                    @foreach ($actions as $action)
                    @if (Route::has($action['route']))
                    <a href="{{ route($action['route']) }}"
                        class="group flex items-center gap-4 rounded-xl border border-slate-200 p-4 transition hover:border-[#d1935c]/60 hover:bg-orange-50/30">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-slate-50 text-slate-600 transition group-hover:bg-orange-100 group-hover:text-[#b87d49]">
                            @if ($action['icon'] === 'book')
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                            </svg>
                            @elseif ($action['icon'] === 'course')
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m3 9 9-5 9 5-9 5-9-5ZM7 11.2V16l5 3 5-3v-4.8M21 9v6" />
                            </svg>
                            @elseif ($action['icon'] === 'calendar')
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <rect x="3" y="4" width="18" height="17" rx="2" />
                                <path stroke-linecap="round" d="M16 2v4M8 2v4M3 10h18" />
                            </svg>
                            @else
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2M10 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8ZM20 8v6m3-3h-6" />
                            </svg>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm font-semibold text-slate-900">
                                {{ $action['title'] }}
                            </h3>
                            <p class="mt-1 text-xs leading-5 text-slate-500">
                                {{ $action['description'] }}
                            </p>
                        </div>

                        <svg class="h-4 w-4 shrink-0 text-slate-400 transition group-hover:translate-x-1 group-hover:text-[#b87d49]"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                        </svg>
                    </a>
                    @endif
                    @endforeach

                </div>
            </div>
        </div>

        {{-- Academic Overview --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="text-base font-bold text-slate-900">Academic Overview</h2>
                <p class="mt-1 text-sm text-slate-500">Your academic records at a glance.</p>
            </div>

            <div class="space-y-1 p-5">
                <div class="flex items-center justify-between rounded-xl px-3 py-4 transition hover:bg-slate-50">
                    <div class="flex items-center gap-3">
                        <span class="h-2.5 w-2.5 rounded-full bg-[#d1935c]"></span>
                        <span class="text-sm font-medium text-slate-600">Subjects</span>
                    </div>
                    <span class="text-lg font-bold text-slate-900">
                        {{ number_format($totalSubjects ?? 0) }}
                    </span>
                </div>

                <div class="flex items-center justify-between rounded-xl px-3 py-4 transition hover:bg-slate-50">
                    <div class="flex items-center gap-3">
                        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>
                        <span class="text-sm font-medium text-slate-600">Courses</span>
                    </div>
                    <span class="text-lg font-bold text-slate-900">
                        {{ number_format($totalCourses ?? 0) }}
                    </span>
                </div>

                <div class="flex items-center justify-between rounded-xl px-3 py-4 transition hover:bg-slate-50">
                    <div class="flex items-center gap-3">
                        <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                        <span class="text-sm font-medium text-slate-600">Academic Years</span>
                    </div>
                    <span class="text-lg font-bold text-slate-900">
                        {{ number_format($totalAcademicYears ?? 0) }}
                    </span>
                </div>

                <div class="mt-4 rounded-xl bg-orange-50/80 p-4">
                    <div class="flex items-start gap-3">
                        <svg class="mt-0.5 h-5 w-5 shrink-0 text-[#b87d49]" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a7 7 0 0 0-4 12.7c.6.4 1 1 1 1.8h6c0-.8.4-1.4 1-1.8A7 7 0 0 0 12 3ZM9 21h6m-5-3v3m4-3v3" />
                        </svg>
                        <p class="text-xs leading-5 text-[#895e39]">
                            Keep academic records up to date for smoother school operations.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Recent Subjects --}}
    <section class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
        <div class="flex flex-col gap-3 border-b border-slate-100 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-900">Recent Subjects</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Recently created or updated academic subjects.
                </p>
            </div>

            @if (Route::has('admin.academic-subjects.index'))
            <a href="{{ route('admin.academic-subjects.index') }}"
                class="inline-flex w-fit items-center gap-2 text-sm font-semibold text-[#b87d49] transition hover:text-[#95663c]">
                View all subjects
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6 6 6-6 6" />
                </svg>
            </a>
            @endif
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-left">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            #
                        </th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Subject Code
                        </th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Subject Name
                        </th>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Record ID
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse (($recentSubjects ?? collect()) as $subject)
                    <tr class="transition hover:bg-slate-50/70">
                        <td class="px-5 py-4 text-sm text-slate-400">
                            {{ $loop->iteration }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex rounded-md bg-orange-50 px-2.5 py-1 text-xs font-semibold text-[#9a6536]">
                                {{ $subject->subject_code }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-sm font-medium text-slate-800">
                            {{ $subject->subject_name }}
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-500">
                            {{ $subject->subject_id }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-5 py-12 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
                                </svg>
                            </div>
                            <p class="mt-3 text-sm font-semibold text-slate-700">
                                No recent subjects
                            </p>
                            <p class="mt-1 text-xs text-slate-500">
                                Subject records will appear here when available.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection