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
            <span id="studentResultCount" class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                {{ number_format($students->total()) }} records
            </span>
            @endif
        </div>

        {{-- Search and Filters --}}
        <form id="studentSearchForm" action="{{ url()->current() }}" method="GET"
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
                    id="studentSearchInput"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search student name, ID, email, or phone..."
                    class="block w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-3 text-sm text-gray-700 placeholder:text-gray-400 focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-[#d1935c]/20">
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <select id="studentStatusFilter" name="status"
                    class="rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-[#d1935c]/20">
                    <option value="">All statuses</option>
                    <option value="1" @selected(in_array((string) request('status'), ['1', 'active'], true))>
                        Active
                    </option>
                    <option value="0" @selected(in_array((string) request('status'), ['0', 'inactive'], true))>
                        Inactive
                    </option>
                    <option value="draft" @selected(request('status')==='draft' )>
                        Draft
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

                <a id="studentSearchReset" href="{{ url()->current() }}"
                    class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100">
                    Reset
                </a>
            </div>
        </form>

        <div id="studentResults" aria-live="polite">
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
                            Address
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

                    $status = strtolower((string) ($student->status ?? 'draft'));
                    $statusLabel = match ($status) {
                    '1', 'active' => 'Active',
                    '0', 'inactive' => 'Inactive',
                    default => ucfirst($status),
                    };

                    $statusClass = match ($status) {
                    '1', 'active' => 'bg-green-50 text-green-700',
                    '0', 'inactive' => 'bg-gray-100 text-gray-600',
                    default => 'bg-orange-50 text-orange-700',
                    };

                    $currentAddress = collect([
                    $student->curr_addr_village,
                    $student->curr_addr_commune,
                    $student->curr_addr_district,
                    $student->curr_addr_province,
                    ])->filter(fn ($part) => filled($part))->implode(', ');
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

                        {{-- Current address --}}
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <span class="block max-w-[220px] truncate" title="{{ $currentAddress }}">
                                {{ $currentAddress ?: '—' }}
                            </span>
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
                                <a href="{{ route('admin.people.students.show', $student->student_id) }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600"
                                    title="View student"
                                    aria-label="View student">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>

                                <button type="button"
                                    class="student-edit inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-orange-200 hover:bg-orange-50 hover:text-[#b87d49]"
                                    data-endpoint="{{ route('api.v1.students.show', $student->student_id) }}"
                                    data-update-endpoint="{{ route('api.v1.students.update', $student->student_id) }}"
                                    title="Edit student"
                                    aria-label="Edit student">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11-11a2.121 2.121 0 0 0-3-3l-11 11L4 20Z" />
                                    </svg>
                                </button>

                                <button type="button"
                                    class="student-delete inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-500 transition hover:border-red-200 hover:bg-red-50 hover:text-red-600"
                                    data-endpoint="{{ route('api.v1.students.destroy', $student->student_id) }}"
                                    data-student-name="{{ $fullName }}"
                                    title="Delete student"
                                    aria-label="Delete student">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 7h16M10 11v6m4-6v6M5 7l1 14h12l1-14M9 7V4h6v3" />
                                    </svg>
                                </button>
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
                            <a id="studentClearFilters" href="{{ url()->current() }}"
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
</div>

<dialog id="studentEditDialog" class="w-[min(94vw,900px)] rounded-xl p-0 shadow-2xl backdrop:bg-gray-950/50">
    <form id="studentEditForm" class="max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-200 bg-white px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Edit Student</h2>
            <button type="button" id="closeStudentEdit" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100" aria-label="Close">&times;</button>
        </div>
        <div class="space-y-5 p-6">
            <div id="studentEditMessage" class="hidden"></div>
            <div class="grid gap-4 sm:grid-cols-2">
                <label class="text-sm font-medium text-gray-700">First name (English)
                    <input id="editStudentFirstNameEn" required maxlength="100" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Last name (English)
                    <input id="editStudentLastNameEn" required maxlength="100" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">First name (Khmer)
                    <input id="editStudentFirstNameKh" required maxlength="100" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Last name (Khmer)
                    <input id="editStudentLastNameKh" required maxlength="100" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Gender
                    <select id="editStudentGender" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                </label>
                <label class="text-sm font-medium text-gray-700">Date of birth
                    <input id="editStudentDob" type="date" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Phone 1
                    <input id="editStudentPhone1" required maxlength="20" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Phone 2
                    <input id="editStudentPhone2" maxlength="20" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Email
                    <input id="editStudentEmail" type="email" maxlength="150" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Academic year
                    <input id="editStudentAcademicYear" required maxlength="100" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Registration date
                    <input id="editStudentRegisterAt" type="date" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                </label>
                <label class="text-sm font-medium text-gray-700">Status
                    <select id="editStudentStatus" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="draft">Draft</option>
                    </select>
                </label>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h3 class="mb-3 text-sm font-semibold text-gray-900">Guardians</h3>
                <div class="grid gap-4 sm:grid-cols-2">
                    <label class="text-sm font-medium text-gray-700">Guardian 1 name
                        <input id="editStudentGuardian1Name" required maxlength="150" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                    <label class="text-sm font-medium text-gray-700">Guardian 1 relationship
                        <input id="editStudentGuardian1Relationship" required maxlength="150" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                    <label class="text-sm font-medium text-gray-700">Guardian 1 phone
                        <input id="editStudentGuardian1Phone" maxlength="20" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                    <label class="text-sm font-medium text-gray-700">Guardian 2 name
                        <input id="editStudentGuardian2Name" required maxlength="150" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                    <label class="text-sm font-medium text-gray-700">Guardian 2 relationship
                        <input id="editStudentGuardian2Relationship" required maxlength="150" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                    <label class="text-sm font-medium text-gray-700">Guardian 2 phone
                        <input id="editStudentGuardian2Phone" maxlength="20" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                    <label class="text-sm font-medium text-gray-700 sm:col-span-2">Guardian email
                        <input id="editStudentGuardianEmail" type="email" maxlength="150" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2">
                    </label>
                </div>
            </div>
        </div>
        <div class="flex justify-end gap-3 border-t border-gray-200 bg-gray-50 px-6 py-4">
            <button type="button" id="cancelStudentEdit" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700">Cancel</button>
            <button type="submit" id="saveStudentEdit" class="rounded-lg bg-[#d1935c] px-4 py-2 text-sm font-semibold text-white hover:bg-[#b87d49]">Save Changes</button>
        </div>
    </form>
</dialog>

@push('scripts')
<script>
    const studentSearchForm = document.getElementById('studentSearchForm');
    const studentSearchInput = document.getElementById('studentSearchInput');
    const studentStatusFilter = document.getElementById('studentStatusFilter');
    const studentSearchReset = document.getElementById('studentSearchReset');
    const studentResults = document.getElementById('studentResults');
    const studentResultCount = document.getElementById('studentResultCount');
    const studentSearchMessage = document.createElement('p');
    studentSearchMessage.className = 'hidden px-4 py-2 text-sm text-red-600';
    studentSearchMessage.setAttribute('role', 'status');
    studentSearchMessage.setAttribute('aria-live', 'polite');
    studentSearchForm.insertAdjacentElement('afterend', studentSearchMessage);
    let studentSearchTimeout;
    let activeStudentSearch;

    async function loadStudents(url, historyMode = 'replace') {
        if (activeStudentSearch) {
            activeStudentSearch.abort();
        }

        const controller = new AbortController();
        activeStudentSearch = controller;
        studentResults.setAttribute('aria-busy', 'true');
        studentSearchMessage.classList.add('hidden');

        try {
            const response = await fetch(url, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error(`Student search failed (${response.status}).`);
            }

            const responseDocument = new DOMParser().parseFromString(await response.text(), 'text/html');
            const updatedResults = responseDocument.getElementById('studentResults');
            const updatedResultCount = responseDocument.getElementById('studentResultCount');
            if (!updatedResults || !updatedResultCount) {
                throw new Error('Student search response did not contain results.');
            }

            studentResults.innerHTML = updatedResults.innerHTML;
            studentResultCount.textContent = updatedResultCount.textContent;
            if (historyMode === 'push') {
                window.history.pushState({}, '', url.toString());
            } else if (historyMode === 'replace') {
                window.history.replaceState({}, '', url.toString());
            }
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            console.error('Could not load student search results:', error);
            studentSearchMessage.textContent = 'Could not load students. Please try again.';
            studentSearchMessage.classList.remove('hidden');
        } finally {
            if (activeStudentSearch === controller) {
                activeStudentSearch = null;
                studentResults.removeAttribute('aria-busy');
            }
        }
    }

    function searchStudents() {
        const url = new URL(studentSearchForm.action, window.location.href);
        const params = new URLSearchParams(new FormData(studentSearchForm));
        if (!studentSearchInput.value.trim()) {
            params.delete('search');
        }
        if (!studentStatusFilter.value) {
            params.delete('status');
        }
        url.search = params.toString();
        loadStudents(url);
    }

    studentSearchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        window.clearTimeout(studentSearchTimeout);
        searchStudents();
    });

    studentSearchInput.addEventListener('input', () => {
        window.clearTimeout(studentSearchTimeout);
        studentSearchTimeout = window.setTimeout(searchStudents, 400);
    });

    studentStatusFilter.addEventListener('change', () => {
        window.clearTimeout(studentSearchTimeout);
        searchStudents();
    });

    studentSearchReset.addEventListener('click', (event) => {
        event.preventDefault();
        window.clearTimeout(studentSearchTimeout);
        studentSearchInput.value = '';
        studentStatusFilter.value = '';
        searchStudents();
    });

    studentResults.addEventListener('click', (event) => {
        const paginationLink = event.target.closest('a');
        if (!paginationLink || !studentResults.contains(paginationLink)) {
            return;
        }

        const isClearFilters = paginationLink.id === 'studentClearFilters';
        const linkUrl = new URL(paginationLink.href, window.location.href);
        if (!isClearFilters && !linkUrl.searchParams.has('page')) {
            return;
        }

        if (isClearFilters) {
            event.preventDefault();
            studentSearchInput.value = '';
            studentStatusFilter.value = '';
            loadStudents(linkUrl);
        } else {
            event.preventDefault();
            loadStudents(linkUrl, 'push');
        }
    });

    window.addEventListener('popstate', () => {
        const url = new URL(window.location.href);
        studentSearchInput.value = url.searchParams.get('search') || '';
        studentStatusFilter.value = url.searchParams.get('status') || '';
        loadStudents(url, 'none');
    });
</script>
@endpush

@endsection