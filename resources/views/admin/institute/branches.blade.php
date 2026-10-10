{{-- resources/views/admin/institute/branches.blade.php --}}

@extends('layouts.admin')

@section('title', 'Branches | 3E ONE')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-medium text-orange-700">
                Institute Management
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-800">
                Branch Management
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage school branches, contact details, and branch status.
            </p>
        </div>

        @if (Route::has('admin.branches.create'))
        <a href="{{ route('admin.branches.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-[#d1935c] px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-[#bd7e49]">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="2">
                <path d="M12 5v14M5 12h14" />
            </svg>
            Add Branch
        </a>
        @endif
    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-700"
        role="status">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"
        role="alert">
        {{ session('error') }}
    </div>
    @endif

    {{-- Summary Cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

        {{-- Total Branches --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Branches</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $totalBranches ?? (isset($branches) ? $branches->total() : 0) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">
                        <path d="M3 21V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v16" />
                        <path d="M3 10h18M8 10v11M16 10v11M1 21h22" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Active Branches --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Active Branches</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $activeBranches ?? '—' }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <path d="m5 12 4 4L19 6" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Inactive Branches --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Inactive Branches</p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $inactiveBranches ?? '—' }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="9" />
                        <path d="M9 9l6 6M15 9l-6 6" />
                    </svg>
                </div>
            </div>
        </div>

    </div>

    {{-- Search and Filter --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
        <form action="{{ url()->current() }}"
            method="GET"
            class="flex flex-col gap-3 sm:flex-row">

            <div class="relative flex-1">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                    viewBox="0 0 24 24"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.35-4.35" />
                </svg>

                <input type="search"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search branch name, code, or email..."
                    class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-[#d1935c] focus:ring-2 focus:ring-orange-100">
            </div>

            <select name="status"
                class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 outline-none focus:border-[#d1935c] focus:ring-2 focus:ring-orange-100">
                <option value="">All Statuses</option>
                <option value="1" @selected(request('status')==='1' )>Active</option>
                <option value="0" @selected(request('status')==='0' )>Inactive</option>
            </select>

            <button type="submit"
                class="rounded-xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                Search
            </button>

            @if (request()->hasAny(['search', 'status']))
            <a href="{{ url()->current() }}"
                class="rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                Reset
            </a>
            @endif
        </form>
    </div>

    {{-- Branch List Heading --}}
    <div class="mb-4">
        <h2 class="text-lg font-bold text-slate-800">All Branches</h2>
        <p class="mt-1 text-sm text-slate-500">
            {{ isset($branches) ? $branches->total() : 0 }} branches found
        </p>
    </div>

    {{-- Branch Cards --}}
    @if (isset($branches) && $branches->count())

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">

        @foreach ($branches as $branch)
        @php
        $isActive = (int) $branch->status === 1;
        @endphp

        <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg">

            <div class="h-1.5 bg-gradient-to-r from-[#d1935c] to-orange-300"></div>

            <div class="p-5">

                {{-- Branch Header --}}
                <div class="mb-5 flex items-start justify-between gap-3">
                    <div class="flex min-w-0 items-center gap-3">
                        <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-[#bd7e49] transition group-hover:bg-orange-100">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-6 w-6"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8">
                                <path d="M3 21V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v16" />
                                <path d="M3 10h18M8 10v11M16 10v11M1 21h22" />
                            </svg>
                        </div>

                        <div class="min-w-0">
                            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                                {{ $branch->branch_code }}
                            </p>
                            <h3 class="mt-1 break-words text-lg font-bold text-slate-800">
                                {{ $branch->branch_name }}
                            </h3>
                        </div>
                    </div>

                    <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ $isActive
                                    ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-200'
                                    : 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200' }}">
                        {{ $isActive ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                {{-- Branch Contact Details --}}
                <div class="space-y-3">

                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.79 19.79 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.96.36 1.9.7 2.79a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.89.34 1.83.58 2.79.7a2 2 0 0 1 1.74 2.03Z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-400">Phone</p>
                            <p class="break-words text-sm font-medium text-slate-700">
                                {{ $branch->phone1 ?: 'Not provided' }}
                            </p>
                            @if ($branch->phone2)
                            <p class="mt-1 text-sm text-slate-500">
                                {{ $branch->phone2 }}
                            </p>
                            @endif
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">
                                <rect x="3" y="5" width="18" height="14" rx="2" />
                                <path d="m3 7 9 6 9-6" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-400">Email</p>
                            <p class="break-words text-sm font-medium text-slate-700">
                                {{ $branch->email ?: 'Not provided' }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="mt-0.5 text-slate-400">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="2">
                                <path d="M20 10c0 5-8 12-8 12S4 15 4 10a8 8 0 1 1 16 0Z" />
                                <circle cx="12" cy="10" r="2.5" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-slate-400">Address</p>
                            <p class="break-words text-sm text-slate-700">
                                {{ $branch->address ?: 'Address not provided' }}
                            </p>
                        </div>
                    </div>

                    @if ($branch->location)
                    <div class="rounded-lg bg-slate-50 px-3 py-2">
                        <p class="text-xs text-slate-400">Location</p>
                        <p class="mt-1 break-words text-sm text-slate-600">
                            {{ $branch->location }}
                        </p>
                    </div>
                    @endif

                </div>

                {{-- Card Actions --}}
                <div class="mt-5 flex items-center gap-2 border-t border-slate-100 pt-4">

                    @if (Route::has('admin.branches.edit'))
                    <a href="{{ route('admin.branches.edit', $branch->branch_id) }}"
                        class="inline-flex flex-1 items-center justify-center gap-2 rounded-lg border border-slate-200 px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:border-orange-200 hover:bg-orange-50 hover:text-orange-700">
                        Edit
                    </a>
                    @endif

                    @if (Route::has('admin.branches.destroy'))
                    <form action="{{ route('admin.branches.destroy', $branch->branch_id) }}"
                        method="POST"
                        class="flex-1"
                        onsubmit="return confirm('Are you sure you want to delete this branch?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="w-full rounded-lg border border-red-100 px-3 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                            Delete
                        </button>
                    </form>
                    @endif

                </div>
            </div>
        </article>
        @endforeach

    </div>

    {{-- Pagination --}}
    @if (method_exists($branches, 'links'))
    <div class="mt-6">
        {{ $branches->withQueryString()->links() }}
    </div>
    @endif

    @else

    {{-- Empty State --}}
    <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">
        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-orange-50 text-[#bd7e49]">
            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8"
                viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8">
                <path d="M3 21V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v16" />
                <path d="M3 10h18M8 10v11M16 10v11M1 21h22" />
            </svg>
        </div>

        <h3 class="mt-5 text-lg font-bold text-slate-800">
            No branches found
        </h3>

        <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
            No branches match your search. Try another keyword or create a new branch.
        </p>

        @if (Route::has('admin.branches.create'))
        <a href="{{ route('admin.branches.create') }}"
            class="mt-5 inline-flex items-center justify-center rounded-xl bg-[#d1935c] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#bd7e49]">
            + Add Branch
        </a>
        @endif
    </div>

    @endif

</div>
@endsection