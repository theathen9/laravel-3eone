{{-- resources/views/admin/academic/academic-years.blade.php --}}

@extends('layouts.admin')

@section('title', 'Academic Years | 3EONE')

@section('content')
<div class="mx-auto w-full max-w-screen-2xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                <span>Academic</span>
                <span>/</span>
                <span class="font-medium text-[#b87d49]">Academic Years</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                Academic Year Management
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage academic years, registration periods, and school-year status.
            </p>
        </div>

        @if (Route::has('admin.academic-years.create'))
        <a href="{{ route('admin.academic-years.create') }}"
            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#d1935c] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#b87d49] focus:outline-none focus:ring-2 focus:ring-[#d1935c] focus:ring-offset-2">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 5v14m7-7H5" />
            </svg>
            Add Academic Year
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

        {{-- Total --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-[#b87d49]">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="5" width="18" height="16" rx="2" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 3v4M8 3v4M3 10h18" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Academic Years</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($totalAcademicYears ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Active --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m5 12 4 4L19 6" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Active Years</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($activeAcademicYears ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Inactive --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-500">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9" />
                        <path stroke-linecap="round" d="M5.6 5.6 18.4 18.4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Inactive Years</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($inactiveAcademicYears ?? 0) }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Current --}}
        <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-5">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 8v4l3 2m6-2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Current Year</p>
                    <p class="mt-1 truncate text-xl font-bold text-gray-900">
                        {{ $currentAcademicYear->academic_year ?? 'Not set' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Academic Year Directory --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">
                    Academic Year Directory
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    View and manage your school's academic years.
                </p>
            </div>

            @if (isset($academicYears) && method_exists($academicYears, 'total'))
            <span class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                {{ number_format($academicYears->total()) }} records
            </span>
            @endif
        </div>

        {{-- Search and Filters --}}
        <form action="{{ url()->current() }}" method="GET"
            class="flex flex-col gap-3 border-b border-gray-200 bg-gray-50/70 p-4 sm:flex-row sm:items-center">

            <div class="relative min-w-0 flex-1">
                <svg class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="1.8">
                    <circle cx="11" cy="11" r="7" />
                    <path stroke-linecap="round" d="m16 16 4 4" />
                </svg>

                <input type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search academic year..."
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
                    class="inline-flex items-center justify-center rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">
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
            <table class="w-full min-w-[850px] text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Academic Year
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            Start Date
                        </th>
                        <th class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                            End Date
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
                    @forelse ($academicYears ?? [] as $academicYear)
                    @php
                    $status = (int) ($academicYear->status ?? 0);

                    $statusLabel = $status === 1 ? 'Active' : 'Inactive';

                    $statusClass = $status === 1
                    ? 'bg-green-50 text-green-700'
                    : 'bg-gray-100 text-gray-600';
                    @endphp

                    <tr class="transition-colors hover:bg-orange-50/40">
                        <td class="px-5 py-4">
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $academicYear->academic_year ?? 'Unnamed academic year' }}
                            </p>
                        </td>

                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                            {{ $academicYear->start_date
                                    ? \Illuminate\Support\Carbon::parse($academicYear->start_date)->format('d M Y')
                                    : '—' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                            {{ $academicYear->end_date
                                    ? \Illuminate\Support\Carbon::parse($academicYear->end_date)->format('d M Y')
                                    : '—' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">
                                <span class="h-1.5 w-1.5 rounded-full {{ $status === 1 ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                {{ $statusLabel }}
                            </span>
                        </td>

                        <td class="whitespace-nowrap px-5 py-4">
                            <div class="flex items-center justify-end gap-2">
                                @if (Route::has('admin.academic-years.show'))
                                <a href="{{ route('admin.academic-years.show', $academicYear->getKey()) }}"
                                    title="View academic year"
                                    aria-label="View academic year"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                @endif

                                @if (Route::has('admin.academic-years.edit'))
                                <a href="{{ route('admin.academic-years.edit', $academicYear->getKey()) }}"
                                    title="Edit academic year"
                                    aria-label="Edit academic year"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-orange-200 hover:bg-orange-50 hover:text-[#b87d49]">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11-11a2.121 2.121 0 0 0-3-3l-11 11L4 20Z" />
                                    </svg>
                                </a>
                                @endif

                                @if (!Route::has('admin.academic-years.show') && !Route::has('admin.academic-years.edit'))
                                <button type="button" disabled
                                    class="inline-flex cursor-not-allowed items-center rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-xs font-medium text-gray-400">
                                    No actions
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-orange-50 text-[#b87d49]">
                                <svg class="h-7 w-7" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <rect x="3" y="5" width="18" height="16" rx="2" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 3v4M8 3v4M3 10h18" />
                                </svg>
                            </div>

                            <h3 class="mt-4 text-sm font-semibold text-gray-900">
                                No academic years found
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
        @if (isset($academicYears) && method_exists($academicYears, 'links'))
        <div class="border-t border-gray-200 px-5 py-4">
            {{ $academicYears->withQueryString()->links() }}
        </div>
        @endif

    </div>
</div>
@endsection