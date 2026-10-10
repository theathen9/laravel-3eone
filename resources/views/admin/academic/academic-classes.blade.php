{{-- resources/views/admin/academic/academic-classes.blade.php --}}

@extends('layouts.admin')

@section('title', 'Classes')

@section('content')
<div class="mx-auto w-full max-w-screen-2xl space-y-6">


    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <div class="mb-2 flex items-center gap-2 text-sm text-gray-500">
                <span>Academic</span>
                <span>/</span>
                <span class="font-medium text-[#b87d49]">Academic Classes</span>
            </div>

            <h1 class="text-2xl font-bold tracking-tight text-gray-900">
                Academic Classes Management
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage classes, grade levels, rooms, and academic Classes.
            </p>
        </div>

        @if (Route::has('admin.academic-classes.create'))
        <a href="{{ route('admin.academic-classes.create') }}"
            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg bg-[#d1935c] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#b87d49] focus:outline-none focus:ring-2 focus:ring-[#d1935c] focus:ring-offset-2">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 5v14m7-7H5" />
            </svg>
            Add Class
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
                    <p class="text-sm text-gray-500">Total Academic Class</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($totalAcademicClass ?? 0) }}
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
                    <p class="text-sm text-gray-500">Active Class</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($activeAcademicClass ?? 0) }}
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
                    <p class="text-sm text-gray-500">Inactive Class</p>
                    <p class="mt-1 text-2xl font-bold text-gray-900">
                        {{ number_format($inactiveAcademicClass ?? 0) }}
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
                    <p class="text-muted small mb-1">Unassigned Classes</p>
                    <h4 class="fw-bold text-warning mb-0">
                        {{ $unassignedClasses ?? 0 }}
                    </h4>
                </div>
            </div>
        </div>
    </div>

    {{-- Academic Classes Directory --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex flex-col gap-3 border-b border-gray-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">
                    Academic Classe Directory
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    View and manage your school's academic Classes.
                </p>
            </div>

            @if (isset($academicClasses) && method_exists($academicClasses, 'total'))
            <span class="inline-flex w-fit items-center rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">
                {{ number_format($academicClasses->total()) }} records
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
                    placeholder="Search academic Classe..."
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
                            Academic Classe
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
                    @forelse ($academicClasses ?? [] as $academicClasse)
                    @php
                    $status = (int) ($academicClasse->status ?? 0);

                    $statusLabel = $status === 1 ? 'Active' : 'Inactive';

                    $statusClass = $status === 1
                    ? 'bg-green-50 text-green-700'
                    : 'bg-gray-100 text-gray-600';
                    @endphp

                    <tr class="transition-colors hover:bg-orange-50/40">
                        <td class="px-5 py-4">
                            <p class="text-sm font-semibold text-gray-900">
                                {{ $academicClasse->academic_Classe ?? 'Unnamed academic Classe' }}
                            </p>
                        </td>

                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                            {{ $academicClasse->start_date
                                    ? \Illuminate\Support\Carbon::parse($academicClasse->start_date)->format('d M Y')
                                    : '—' }}
                        </td>

                        <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                            {{ $academicClasse->end_date
                                    ? \Illuminate\Support\Carbon::parse($academicClasse->end_date)->format('d M Y')
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
                                @if (Route::has('admin.academic-Classes.show'))
                                <a href="{{ route('admin.academic-Classes.show', $academicClasse->getKey()) }}"
                                    title="View academic Classe"
                                    aria-label="View academic Classe"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-600">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12s3.5-7 9.75-7 9.75 7 9.75 7-3.5 7-9.75 7-9.75-7-9.75-7Z" />
                                        <circle cx="12" cy="12" r="3" />
                                    </svg>
                                </a>
                                @endif

                                @if (Route::has('admin.academic-Classes.edit'))
                                <a href="{{ route('admin.academic-Classes.edit', $academicClasse->getKey()) }}"
                                    title="Edit academic Classe"
                                    aria-label="Edit academic Classe"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-gray-200 text-gray-600 transition hover:border-orange-200 hover:bg-orange-50 hover:text-[#b87d49]">
                                    <svg class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m16.862 4.487 2.651 2.651M4 20l4.5-1 11-11a2.121 2.121 0 0 0-3-3l-11 11L4 20Z" />
                                    </svg>
                                </a>
                                @endif

                                @if (!Route::has('admin.academic-Classes.show') && !Route::has('admin.academic-Classes.edit'))
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
                                No academic Classes found
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
        @if (isset($academicClasses) && method_exists($academicClasses, 'links'))
        <div class="border-t border-gray-200 px-5 py-4">
            {{ $academicClasses->withQueryString()->links() }}
        </div>
        @endif

    </div>
</div>
@endsection