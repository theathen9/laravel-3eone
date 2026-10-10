{{-- resources/views/admin/people/students.blade.php --}}

@extends('layouts.admin')

@section('title', 'Students | 3EONE')

@section('content')

<div class="mx-auto w-full max-w-screen-2xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                <span>People</span>
                <span>/</span>
                <span class="font-medium text-[#b87d49]">Students</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                Student Management
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage student profiles, enrollment information, and student status.
            </p>
        </div>

        @if (Route::has('admin.registrations.students'))
        <a href="{{ route('admin.registrations.students') }}"
            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#d1935c] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#b87d49] focus:outline-none focus:ring-2 focus:ring-[#d1935c] focus:ring-offset-2">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 5v14m7-7H5" />
            </svg>
            Add Student
        </a>
        @endif
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
    <div role="status"
        class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div role="alert"
        class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
    @endif

    {{-- Statistics --}}
    <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">

        {{-- Total Students --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-[#b87d49]">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-3a4 4 0 0 1 0 8m2 1h2a3 3 0 0 1 3 3v1" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-sm text-gray-500">Total Students</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($totalStudents ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Active Students --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m5 12 4 4L19 6" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-sm text-gray-500">Active Students</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($activeStudents ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Inactive Students --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3 3 8l9 5 9-5-9-5Zm-7 9v5c4 3 10 3 14 0v-5" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-sm text-gray-500">Inactive Students</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($inactiveStudents ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Unassigned Students --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>

                <div class="min-w-0">
                    <p class="text-sm text-gray-500">Unassigned</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($unassignedStudents ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- Student Directory --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        {{-- Directory Header --}}
        <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">
                    Student Directory
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    View and manage registered student records.
                </p>
            </div>

            @if (isset($students) && method_exists($students, 'total'))
            <span class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                {{ number_format($students->total()) }} records
            </span>
            @endif
        </div>

        {{-- Search and Filters --}}
        <form action="{{ url()->current() }}" method="GET"
            class="flex flex-col gap-3 border-b border-gray-200 bg-gray-50/70 p-4 lg:flex-row lg:items-center">

            <div class="relative min-w-0 flex-1">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <circle cx="11" cy="11" r="7" />
                    <path stroke-linecap="round" d="m16 16 4 4" />
                </svg>

                <input
                    type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search student name, ID, email, or phone..."
                    class="block w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-3 text-sm text-gray-700 placeholder:text-gray-400 focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-[#d1935c]/20">
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <select name="status"
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-[#d1935c]/20">
                    <option value="">All statuses</option>
                    <option value="1" @selected(request('status')==='1' )>
                        Active
                    </option>
                    <option value="0" @selected(request('status')==='0' )>
                        Inactive
                    </option>
                </select>

                <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="7" />
                        <path stroke-linecap="round" d="m16 16 4 4" />
                    </svg>
                    Search
                </button>

                <a href="{{ url()->current() }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100">
                    Reset
                </a>
            </div>
        </form>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[950px] text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Student
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Student ID
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Class / Enrollment
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Contact
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>
                        <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($students ?? [] as $student)
                    @php
                    $fullName = trim(
                    ($student->first_name_en ?? '') . ' ' .
                    ($student->last_name_en ?? '')
                    );

                    $status = (int) ($student->status ?? 1);

                    $statusLabel = match ($status) {
                    1 => 'Active',
                    0 => 'Inactive',
                    default => 'Status ' . $status,
                    };

                    $statusClass = match ($status) {
                    1 => 'bg-green-50 text-green-700',
                    0 => 'bg-gray-100 text-gray-600',
                    default => 'bg-orange-50 text-orange-700',
                    };
                    @endphp

                    <tr class="transition-colors hover:bg-orange-50/40">

                        {{-- Student Profile --}}
                        <td class="px-5 py-4">
                            <div class="flex min-w-0 items-center gap-3">
                                <div class="h-14 w-14 shrink-0 overflow-hidden rounded-full border-2 border-orange-100 bg-orange-50">
                                    @if (!empty($student->profile_image))
                                    <img
                                        src="{{ asset('storage/' . $student->profile_image) }}"
                                        alt="{{ $fullName ?: 'Student' }}"
                                        loading="lazy"
                                        class="block h-full w-full object-cover">
                                    @else
                                    <div class="flex h-full w-full items-center justify-center text-lg font-bold text-[#b87d49]">
                                        {{ strtoupper(substr($fullName ?: 'S', 0, 1)) }}
                                    </div>
                                    @endif
                                </div>

                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-900">
                                        {{ $fullName ?: 'Unnamed Student' }}
                                    </p>

                                    @if (!empty($student->first_name_kh) || !empty($student->last_name_kh))
                                    <p class="mt-1 truncate text-xs text-gray-500">
                                        {{ trim(($student->first_name_kh ?? '') . ' ' . ($student->last_name_kh ?? '')) }}
                                    </p>
                                    @endif

                                    @if (!empty($student->gender))
                                    <p class="mt-1 text-xs text-gray-500">
                                        {{ ucfirst($student->gender) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Student ID --}}
                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                            {{ $student->student_code ?? ('STU-' . str_pad($student->student_id, 5, '0', STR_PAD_LEFT)) }}
                        </td>

                        {{-- Class / Enrollment --}}
                        <td class="px-4 py-4 text-sm text-gray-700">
                            @if (isset($student->enrollments) && $student->enrollments->isNotEmpty())
                            @foreach ($student->enrollments as $enrollment)
                            <p class="font-medium">
                                {{ $enrollment->class->class_name ?? $enrollment->class_name ?? 'Class not assigned' }}
                            </p>

                            @if (!$loop->last)
                            <p class="my-1 border-b border-gray-100"></p>
                            @endif
                            @endforeach
                            @else
                            <span class="text-gray-400">Not enrolled</span>
                            @endif
                        </td>

                        {{-- Contact --}}
                        <td class="px-4 py-4">
                            <p class="break-words text-sm text-gray-700">
                                {{ $student->email ?: '—' }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $student->phone1 ?? $student->phone ?? 'No phone number' }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="whitespace-nowrap px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $status === 1 ? 'bg-green-500' : ($status === 0 ? 'bg-gray-400' : 'bg-orange-500') }}"></span>
                                {{ $statusLabel }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="whitespace-nowrap px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                @if (Route::has('admin.students.show'))
                                <a href="{{ route('admin.students.show', $student->student_id) }}"
                                    title="View student"
                                    aria-label="View student"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                @endif

                                @if (Route::has('admin.students.edit'))
                                <a href="{{ route('admin.students.edit', $student->student_id) }}"
                                    title="Edit student"
                                    aria-label="Edit student"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-orange-200 hover:bg-orange-50 hover:text-[#b87d49]">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11-11a2.121 2.121 0 0 0-3-3l-11 11L4 20Z" />
                                    </svg>
                                </a>
                                @endif

                                @if (!Route::has('admin.students.show') && !Route::has('admin.students.edit'))
                                <button type="button"
                                    disabled
                                    title="Student actions are not configured yet"
                                    class="inline-flex cursor-not-allowed items-center gap-2 rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs font-medium text-gray-400">
                                    No actions
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-orange-50 text-[#b87d49]">
                                <svg class="h-7 w-7" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                                </svg>
                            </div>

                            <h3 class="mt-4 text-sm font-semibold text-gray-900">
                                No students found
                            </h3>

                            <p class="mt-1 text-sm text-gray-500">
                                Try changing your search or status filter.
                            </p>

                            @if (request()->hasAny(['search', 'status']))
                            <a href="{{ url()->current() }}"
                                class="mt-3 inline-flex text-sm font-semibold text-[#b87d49] hover:underline">
                                Clear filters
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if (isset($students) && method_exists($students, 'links'))
        <div class="border-t border-gray-200 px-5 py-4">
            {{ $students->withQueryString()->links() }}
        </div>
        @endif

    </div>
</div>

@endsection