{{-- resources/views/admin/institute/positions.blade.php --}}

@extends('layouts.admin')

@section('title', 'Positions | 3E ONE')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 py-6 sm:px-6 lg:px-8">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-medium text-orange-700">
                Institute Management
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-800">
                Employee Positions
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage job titles and employee position records.
            </p>
        </div>

    </div>

    {{-- Flash Messages --}}
    @if (session('success'))
    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 p-3 text-sm text-green-700"
        role="status">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-3 text-sm text-red-700"
        role="alert">
        {{ session('error') }}
    </div>
    @endif

    {{-- Summary Cards --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

        {{-- Total Positions --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Positions
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $totalPositions ?? (isset($positions) ? $positions->total() : 0) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-100 text-orange-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8">
                        <rect x="3" y="4" width="18" height="16" rx="2" />
                        <path d="M8 4V2h8v2M8 10h8M8 14h5" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Active Positions --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Active Positions
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $activePositions ?? '—' }}
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

        {{-- Inactive Positions --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Inactive Positions
                    </p>
                    <p class="mt-2 text-3xl font-bold text-slate-800">
                        {{ $inactivePositions ?? '—' }}
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
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-3 shadow-sm">
        <form id="positionSearchForm" action="{{ url()->current() }}"
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
                    id="positionSearchInput"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search position name..."
                    class="w-full rounded-xl border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none transition placeholder:text-slate-400 focus:border-[#d1935c] focus:ring-2 focus:ring-orange-100">
            </div>

            <select name="status"
                class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 outline-none focus:border-[#d1935c] focus:ring-2 focus:ring-orange-100">
                <option value="">All Statuses</option>
                <option value="1" @selected(request('status')==='1' )>
                    Active
                </option>
                <option value="0" @selected(request('status')==='0' )>
                    Inactive
                </option>
            </select>

            <button type="submit"
                class="rounded-xl bg-slate-800 px-5 py-3 text-sm font-semibold text-white transition hover:bg-slate-700">
                Search
            </button>

            <a id="positionSearchReset" href="{{ url()->current() }}"
                class="{{ request()->hasAny(['search', 'status']) ? '' : 'hidden' }} rounded-xl border border-slate-200 px-5 py-3 text-center text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                Reset
            </a>
        </form>
    </div>

    <div id="positionResults" aria-live="polite">
        {{-- Position Cards Header --}}
        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="text-lg font-bold text-slate-800">
                    All Positions
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    {{ isset($positions) ? $positions->total() : 0 }}
                    positions found
                </p>
            </div>
            <button type="button"
                class="position-create inline-flex items-center justify-center gap-2 rounded-xl bg-[#d1935c] px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#bd7e49]"
                data-endpoint="{{ route('api.v1.positions.store') }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Add Position
            </button>
        </div>

        {{-- Position Cards --}}
        @if (isset($positions) && $positions->count())

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">

            @foreach ($positions as $position)
            @php
            $isActive = (int) $position->status === 1;
            @endphp

            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg">

                <div class="h-1.5 bg-gradient-to-r from-[#d1935c] to-orange-300"></div>

                <div class="p-3">

                    {{-- Position Header --}}
                    <div class=" flex items-start justify-between gap-3">
                        <div class="flex min-w-0 items-center gap-3">

                            <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-[#bd7e49] transition group-hover:bg-orange-100">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6"
                                    viewBox="0 0 24 24"
                                    fill="none"
                                    stroke="currentColor"
                                    stroke-width="1.8">
                                    <rect x="3" y="7" width="18" height="14" rx="2" />
                                    <path d="M8 7V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v3M3 12h18M10 12v2h4v-2" />
                                </svg>
                            </div>

                            <div class="min-w-0">
                                <p class="text-[11px] font-medium uppercase tracking-wider text-slate-400">
                                    Position Code
                                </p>
                                <p class="mt-0.5 truncate font-mono text-lg font-semibold text-slate-700">
                                    {{ $position->position_code ?: '—' }}
                                </p>

                            </div>
                        </div>

                        <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold
                                {{ $isActive
                                    ? 'bg-green-50 text-green-700 ring-1 ring-inset ring-green-200'
                                    : 'bg-slate-100 text-slate-600 ring-1 ring-inset ring-slate-200' }}">
                            {{ $isActive ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    {{-- Position Information --}}
                    <div class="rounded-xl bg-slate-50 p-3">
                        <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                            Position Name
                        </p>
                        <p class="mt-1 break-words text-sm font-semibold text-slate-700">
                            {{ $position->position_name }}
                        </p>
                    </div>

                    {{-- Actions --}}
                    <div class=" grid grid-cols-3 gap-2 border-t border-slate-100 pt-4">
                        <button type="button"
                            class="position-detail inline-flex items-center justify-center gap-1.5 rounded-lg border border-sky-100 bg-sky-50 px-2 py-2.5 text-xs font-semibold text-sky-700 transition hover:bg-sky-100"
                            data-endpoint="{{ route('api.v1.positions.show', $position->position_id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M12 11v5M12 8h.01" />
                            </svg>
                            Detail
                        </button>
                        <button type="button"
                            class="position-edit inline-flex items-center justify-center gap-1.5 rounded-lg border border-orange-100 bg-orange-50 px-2 py-2.5 text-xs font-semibold text-orange-700 transition hover:bg-orange-100"
                            data-endpoint="{{ route('api.v1.positions.show', $position->position_id) }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m16 4 4 4M4 20l4-.8L19.5 7.7a2.12 2.12 0 0 0-3-3L5 16.2 4 20Z" />
                            </svg>
                            Edit
                        </button>
                        <button type="button"
                            class="position-delete inline-flex items-center justify-center gap-1.5 rounded-lg border border-red-100 bg-red-50 px-2 py-2.5 text-xs font-semibold text-red-600 transition hover:bg-red-100"
                            data-endpoint="{{ route('api.v1.positions.destroy', $position->position_id) }}"
                            data-position-name="{{ $position->position_name }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M3 6h18M8 6V4h8v2M19 6l-1 14H6L5 6M10 11v5M14 11v5" />
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </article>
            @endforeach

        </div>

        {{-- Pagination --}}
        @if (method_exists($positions, 'links'))
        <div class="mt-6">
            {{ $positions->withQueryString()->links() }}
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
                    <rect x="3" y="7" width="18" height="14" rx="2" />
                    <path d="M8 7V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v3" />
                </svg>
            </div>

            <h3 class="mt-5 text-lg font-bold text-slate-800">
                No positions found
            </h3>

            <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                No positions match your search. Try another keyword or add a new position.
            </p>

        </div>

        @endif

    </div>
</div>

<dialog id="positionDetailDialog"
    class="m-auto w-[calc(100%-2rem)] max-w-lg rounded-2xl border-0 bg-transparent p-0 backdrop:bg-slate-900/50">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl">
        <div class="flex items-start justify-between border-b border-slate-100 px-5 py-4">
            <div>
                <h2 id="positionDetailName" class="mt-1 text-xl font-bold text-slate-800"></h2>
            </div>
            <button type="button" id="closePositionDetail"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:bg-slate-50"
                aria-label="Close position details">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
        <div class="grid gap-3 p-5 sm:grid-cols-2">
            <div class="rounded-xl bg-slate-50 p-3">
                <p class="text-xs font-medium text-slate-400">Position Code</p>
                <p id="positionDetailCode" class="mt-1 font-mono text-sm font-semibold text-[#b87d49]"></p>
            </div>
            <div class="rounded-xl bg-slate-50 p-3">
                <p class="text-xs font-medium text-slate-400">Status</p>
                <p id="positionDetailStatus" class="mt-1 text-sm font-semibold text-slate-700"></p>
            </div>
            <div class="rounded-xl bg-slate-50 p-3 sm:col-span-2">
                <p class="text-xs font-medium text-slate-400">Description</p>
                <p id="positionDetailDescription" class="mt-1 break-words text-sm text-slate-700"></p>
            </div>
        </div>
    </div>
</dialog>

<dialog id="positionEditDialog"
    class="m-auto w-[calc(100%-2rem)] max-w-lg rounded-2xl border-0 bg-transparent p-0 backdrop:bg-slate-900/50">
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-2xl">
        <div class="flex items-start justify-between border-b border-slate-100 px-5 py-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-[#b87d49]">Institute Management</p>
                <h2 id="positionEditTitle" class="mt-1 text-xl font-bold text-slate-800">Edit Position</h2>
            </div>
            <button type="button" id="closePositionEdit"
                class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-500 transition hover:bg-slate-50"
                aria-label="Close position form">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="m6 6 12 12M18 6 6 18" />
                </svg>
            </button>
        </div>
        <form id="positionEditForm" class="space-y-4 p-5">
            <p id="positionEditMessage" class="hidden rounded-lg p-3 text-sm" role="status" aria-live="polite"></p>
            <label class="block text-sm font-medium text-slate-700">
                Position Code
                <input id="editPositionCode" required maxlength="255"
                    class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
            </label>
            <label class="block text-sm font-medium text-slate-700">
                Position Name
                <input id="editPositionName" required maxlength="255"
                    class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
            </label>
            <label class="block text-sm font-medium text-slate-700">
                Description
                <textarea id="editPositionDescription" rows="3" maxlength="5000"
                    class="mt-1.5 w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100"></textarea>
            </label>
            <label class="block text-sm font-medium text-slate-700">
                Status
                <select id="editPositionStatus"
                    class="mt-1.5 w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-sm focus:border-orange-400 focus:outline-none focus:ring-2 focus:ring-orange-100">
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </label>
            <div class="flex justify-end gap-3 border-t border-slate-100 pt-4">
                <button type="button" id="cancelPositionEdit"
                    class="rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Cancel
                </button>
                <button type="submit" id="savePositionEdit"
                    class="rounded-lg bg-[#d1935c] px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-[#bd7e49] disabled:cursor-not-allowed disabled:opacity-60">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</dialog>

@push('scripts')
<script>
    const positionSearchForm = document.getElementById('positionSearchForm');
    const positionSearchInput = document.getElementById('positionSearchInput');
    const positionStatusFilter = positionSearchForm.querySelector('[name="status"]');
    const positionSearchReset = document.getElementById('positionSearchReset');
    const positionResults = document.getElementById('positionResults');
    const positionSearchMessage = document.createElement('p');
    positionSearchMessage.className = 'hidden mt-3 text-sm text-red-600';
    positionSearchMessage.setAttribute('role', 'status');
    positionSearchMessage.setAttribute('aria-live', 'polite');
    positionSearchForm.parentElement.append(positionSearchMessage);
    let positionSearchTimeout;
    let activePositionSearch;

    function updatePositionSearchReset() {
        positionSearchReset.classList.toggle(
            'hidden',
            !positionSearchInput.value.trim() && !positionStatusFilter.value
        );
    }

    updatePositionSearchReset();

    async function loadPositions(url, historyMode = 'replace') {
        if (activePositionSearch) {
            activePositionSearch.abort();
        }

        const controller = new AbortController();
        activePositionSearch = controller;
        positionResults.setAttribute('aria-busy', 'true');
        positionSearchMessage.classList.add('hidden');

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: controller.signal,
            });

            if (!response.ok) {
                throw new Error(`Position search failed (${response.status}).`);
            }

            const responseDocument = new DOMParser().parseFromString(await response.text(), 'text/html');
            const updatedResults = responseDocument.getElementById('positionResults');
            if (!updatedResults) {
                throw new Error('Position search response did not contain results.');
            }

            positionResults.innerHTML = updatedResults.innerHTML;
            if (historyMode === 'push') {
                window.history.pushState({}, '', url.toString());
            } else if (historyMode === 'replace') {
                window.history.replaceState({}, '', url.toString());
            }
            updatePositionSearchReset();
        } catch (error) {
            if (error.name === 'AbortError') {
                return;
            }

            console.error('Could not load position search results:', error);
            positionSearchMessage.textContent = 'Could not load positions. Please try again.';
            positionSearchMessage.classList.remove('hidden');
        } finally {
            if (activePositionSearch === controller) {
                activePositionSearch = null;
                positionResults.removeAttribute('aria-busy');
            }
        }
    }

    function searchPositions() {
        const url = new URL(positionSearchForm.action, window.location.href);
        const params = new URLSearchParams(new FormData(positionSearchForm));
        if (!positionSearchInput.value.trim()) {
            params.delete('search');
        }
        if (!positionStatusFilter.value) {
            params.delete('status');
        }
        url.search = params.toString();
        loadPositions(url);
    }

    positionSearchForm.addEventListener('submit', (event) => {
        event.preventDefault();
        window.clearTimeout(positionSearchTimeout);
        searchPositions();
    });

    positionSearchInput.addEventListener('input', () => {
        window.clearTimeout(positionSearchTimeout);
        positionSearchTimeout = window.setTimeout(searchPositions, 400);
    });

    positionStatusFilter.addEventListener('change', () => {
        window.clearTimeout(positionSearchTimeout);
        searchPositions();
    });

    positionSearchReset.addEventListener('click', (event) => {
        event.preventDefault();
        window.clearTimeout(positionSearchTimeout);
        positionSearchInput.value = '';
        positionStatusFilter.value = '';
        searchPositions();
    });

    positionResults.addEventListener('click', (event) => {
        const paginationLink = event.target.closest('a');
        if (paginationLink && positionResults.contains(paginationLink)) {
            event.preventDefault();
            loadPositions(paginationLink.href, 'push');
        }
    });

    window.addEventListener('popstate', () => {
        const url = new URL(window.location.href);
        positionSearchInput.value = url.searchParams.get('search') || '';
        positionStatusFilter.value = url.searchParams.get('status') || '';
        updatePositionSearchReset();
        loadPositions(url, 'none');
    });
</script>
@endpush

@endsection