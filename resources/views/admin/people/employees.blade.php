{{-- resources/views/admin/people/employees.blade.php --}}

@extends('layouts.admin')

@section('title', 'Employees | 3EONE')

@section('content')
<div class="mx-auto w-full max-w-screen-2xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <div>
            <div class="mb-1 flex items-center gap-2 text-sm text-gray-500">
                <span>People</span>
                <span>/</span>
                <span class="font-medium text-[#b87d49]">Employees</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                Employee Management
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage employee profiles, positions, and employment status.
            </p>
        </div>

        {{-- Change the route name if your registration route is different. --}}
        @if (Route::has('admin.registrations.employees'))
        <a href="{{ route('admin.registrations.employees') }}"
            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#d1935c] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#b87d49]">
            <svg class="h-11 w-11" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 5v14m7-7H5" />
            </svg>
            Add Employee
        </a>
        @endif
    </div>

    {{-- Notifications --}}
    @if (session('success'))
    <div class="rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
        {{ session('error') }}
    </div>
    @endif

    {{-- Statistics --}}
    <div class="grid grid-cols-2 gap-4 xl:grid-cols-4">

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
                    <p class="text-sm text-gray-500">Total Employees</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($totalEmployees ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

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
                    <p class="text-sm text-gray-500">Active</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($activeEmployees ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m12 3 9 5-9 5-9-5 9-5Zm-7 9v5c4 3 10 3 14 0v-5" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <p class="text-sm text-gray-500">Teachers</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($teacherEmployees ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

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
                    <p class="text-sm text-gray-500">Inactive</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($inactiveEmployees ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- Employee Directory --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        {{-- Directory heading --}}
        <div class="flex flex-col gap-1 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">
                    All Employees
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Employee records and contact information.
                </p>
            </div>

            @if (isset($employees) && method_exists($employees, 'total'))
            <span class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                {{ number_format($employees->total()) }} records
            </span>
            @endif
        </div>

        {{-- Search Toolbar --}}
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
                    placeholder="Search name, employee code, or email..."
                    class="block w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-10 pr-3 text-sm text-gray-700 placeholder:text-gray-400 focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-[#d1935c]/20">
            </div>

            <div class="flex flex-col gap-3 sm:flex-row">
                <select name="status"
                    class="min-w-0 rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 focus:border-[#d1935c] focus:outline-none focus:ring-2 focus:ring-[#d1935c]/20">
                    <option value="">All statuses</option>
                    <option value="active" @selected(request('status')==='active' )>
                        Active
                    </option>
                    <option value="inactive" @selected(request('status')==='inactive' )>
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

        {{-- Employee Table --}}
        <div class="overflow-x-auto">
            <table class="w-full min-w-[850px] table-auto text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="w-[26%] px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Employee
                        </th>
                        <th class="w-[15%] px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Code
                        </th>
                        <th class="w-[16%] px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Position
                        </th>
                        <th class="w-[21%] px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Contact
                        </th>
                        <th class="w-[11%] px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Status
                        </th>
                        <th class="w-[11%] px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-100">
                    @forelse ($employees ?? [] as $employee)
                    @php
                    $fullName = trim(
                    ($employee->first_name_en ?? '') . ' ' .
                    ($employee->last_name_en ?? '')
                    );

                    $isActive = in_array(
                    strtolower((string) ($employee->status ?? '')),
                    ['active', '1'],
                    true
                    );
                    @endphp

                    <tr class="transition-colors hover:bg-orange-50/40">

                        {{-- Employee profile --}}
                        <td class="px-5 py-4">
                            <div class="flex min-w-0 items-center gap-3">
                                {{-- Employee Profile Image --}}
                                <div class="h-18 w-18 shrink-0 overflow-hidden rounded-full border-2 border-orange-100 bg-orange-50">
                                    @if (!empty($employee->profile_image))
                                    <img
                                        src="{{ asset('storage/' . $employee->profile_image) }}"
                                        alt="{{ $fullName ?: 'Employee' }}"
                                        class="block h-full w-full object-cover"
                                        loading="lazy">
                                    @else
                                    <div class="flex h-full w-full items-center justify-center text-lg font-bold text-[#b87d49]">
                                        {{ strtoupper(substr($fullName ?: 'E', 0, 1)) }}
                                    </div>
                                    @endif
                                </div>

                                {{-- Employee Name --}}
                                <div class="min-w-0">
                                    <p class="truncate text-sm font-semibold text-gray-900">
                                        {{ $fullName ?: 'Unnamed Employee' }}
                                    </p>

                                    @if (!empty($employee->first_name_kh) || !empty($employee->last_name_kh))
                                    <p class="mt-1 truncate text-xs text-gray-500">
                                        {{ trim(($employee->first_name_kh ?? '') . ' ' . ($employee->last_name_kh ?? '')) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </td>

                        {{-- Employee code --}}
                        <td class="px-4 py-4 text-sm text-gray-600">
                            {{ $employee->employee_code ?: '—' }}
                        </td>

                        {{-- Position --}}
                        <td class="px-4 py-4 text-sm text-gray-700">
                            {{ $employee->position->position_name ?? 'Not assigned' }}
                        </td>

                        {{-- Contact --}}
                        <td class="px-4 py-4">
                            <p class="break-words text-sm text-gray-700">
                                {{ $employee->email ?: '—' }}
                            </p>
                            <p class="mt-1 text-xs text-gray-500">
                                {{ $employee->phone ?: 'No phone number' }}
                            </p>
                        </td>

                        {{-- Status --}}
                        <td class="px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $isActive ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $isActive ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ $isActive ? 'Active' : 'Inactive' }}
                            </span>
                        </td>



                        {{-- Actions --}}
                        <td class="px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                @if (Route::has('admin.employees.show'))
                                <a href="{{ route('admin.employees.show', $employee->employee_id) }}"
                                    title="View employee"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                @endif

                                @if (Route::has('admin.employees.edit'))
                                <a href="{{ route('admin.employees.edit', $employee->employee_id) }}"
                                    title="Edit employee"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-orange-200 hover:bg-orange-50 hover:text-[#b87d49]">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11-11a2.121 2.121 0 0 0-3-3l-11 11L4 20Z" />
                                    </svg>
                                </a>
                                @endif

                                @if (!Route::has('admin.employees.show') && !Route::has('admin.employees.edit'))
                                <button
                                    type="button"
                                    disabled
                                    title="View and edit actions are not configured yet"
                                    class="inline-flex cursor-not-allowed items-center gap-2 rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs font-medium text-gray-400">
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                        stroke-width="1.8">
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M12 5v14m-7-7h14" />
                                    </svg>
                                    No actions
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                <svg class="h-6 w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
                                </svg>
                            </div>
                            <h3 class="mt-3 text-sm font-semibold text-gray-900">
                                No employees found
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
        @if (isset($employees) && method_exists($employees, 'links'))
        <div class="border-t border-gray-200 px-5 py-4">
            {{ $employees->withQueryString()->links() }}
        </div>
        @endif

    </div>
</div>
@endsection