@extends('layouts.admin')

@section('title', 'Users | 3EONE')

@section('content')
<div class="mx-auto w-full max-w-screen-2xl space-y-6">
    <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#b87d49]">Access management</p>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Users</h1>
            <p class="mt-1 text-sm text-gray-500">Review account access, assigned roles, and sign-in activity.</p>
        </div>
        <span class="inline-flex w-fit items-center gap-2 rounded-full border border-emerald-200 bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">
            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
            Admin workspace
        </span>
    </header>

    <nav aria-label="Access management" class="flex gap-1 overflow-x-auto rounded-xl border border-gray-200 bg-white p-1.5 shadow-sm">
        <a href="{{ route('admin.users.index') }}" aria-current="page" class="whitespace-nowrap rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white">Users</a>
        <a href="{{ route('admin.roles.index') }}" class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">Roles</a>
        <a href="{{ route('admin.permissions.index') }}" class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">Permissions</a>
    </nav>

    <section aria-label="User account statistics" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Total accounts</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($totalUsers) }}</p>
            <p class="mt-1 text-xs text-gray-400">Across all assigned roles</p>
        </article>
        <article class="rounded-xl border border-emerald-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Active</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-emerald-700">{{ number_format($activeUsers) }}</p>
            <p class="mt-1 text-xs text-gray-400">Accounts enabled to sign in</p>
        </article>
        <article class="rounded-xl border border-amber-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Inactive</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-amber-700">{{ number_format($inactiveUsers) }}</p>
            <p class="mt-1 text-xs text-gray-400">Accounts currently disabled</p>
        </article>
        <article class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Available roles</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-blue-700">{{ number_format($totalRoles) }}</p>
            <a href="{{ route('admin.roles.index') }}" class="mt-1 inline-flex text-xs font-semibold text-blue-700 hover:text-blue-900">Review roles <span aria-hidden="true" class="ml-1">→</span></a>
        </article>
    </section>

    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Account directory</h2>
                <p class="mt-1 text-sm text-gray-500">{{ number_format($users->total()) }} matching accounts</p>
            </div>
            <form method="GET" action="{{ route('admin.users.index') }}" class="grid gap-2 sm:grid-cols-[minmax(220px,1fr)_160px_180px_auto_auto]">
                <label class="sr-only" for="userSearch">Search accounts</label>
                <input id="userSearch" type="search" name="search" value="{{ $search }}" placeholder="Search username, email, or reference code"
                    class="min-w-0 rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm outline-none transition placeholder:text-gray-400 focus:border-[#d1935c] focus:ring-4 focus:ring-orange-100">
                <label class="sr-only" for="userRole">Filter by role</label>
                <select id="userRole" name="role_id" class="rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 focus:border-[#d1935c] focus:outline-none focus:ring-4 focus:ring-orange-100">
                    <option value="">All roles</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->role_id }}" @selected((string) $roleId === (string) $role->role_id)>{{ $role->role_name }}</option>
                    @endforeach
                </select>
                <label class="sr-only" for="userStatus">Filter by status</label>
                <select id="userStatus" name="status" class="rounded-lg border border-gray-300 bg-white px-3 py-2.5 text-sm text-gray-700 focus:border-[#d1935c] focus:outline-none focus:ring-4 focus:ring-orange-100">
                    <option value="">All statuses</option>
                    <option value="1" @selected($status === '1')>Active</option>
                    <option value="0" @selected($status === '0')>Inactive</option>
                </select>
                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">Filter</button>
                @if ($search !== '' || $status !== '' || $roleId !== '')
                    <a href="{{ route('admin.users.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-center text-sm font-medium text-gray-600 transition hover:bg-gray-50">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">User</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Role</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Status</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Last sign-in</th>
                        <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Created</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        @php
                            $isActive = (int) $user->status === 1;
                            $userLabel = $user->username ?: $user->email;
                        @endphp
                        <tr class="transition hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <div class="flex min-w-0 items-center gap-3">
                                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-orange-50 text-sm font-bold text-[#b87d49]">{{ strtoupper(substr($userLabel, 0, 1)) }}</span>
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-gray-900">{{ $user->username }}</p>
                                        <p class="truncate text-xs text-gray-500">{{ $user->email }}</p>
                                        <p class="mt-0.5 text-[11px] text-gray-400">{{ $user->reference_type ?: 'Account' }} #{{ $user->reference_id }}</p>
                                        @if ($user->reference_code)
                                            <p class="mt-0.5 font-mono text-[11px] text-[#b87d49]">Reference code: {{ $user->reference_code }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">{{ $user->role?->role_name ?? 'No role' }}</span>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $isActive ? 'bg-emerald-50 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                    <span class="h-1.5 w-1.5 rounded-full {{ $isActive ? 'bg-emerald-500' : 'bg-gray-400' }}"></span>
                                    {{ $isActive ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-600">{{ $user->last_login?->format('M d, Y · H:i') ?? 'Never' }}</td>
                            <td class="px-5 py-4 text-right text-sm text-gray-500">{{ $user->created_at?->format('M d, Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-16 text-center">
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-3a4 4 0 0 1 0 8m2 1h2a3 3 0 0 1 3 3v1" />
                                    </svg>
                                </div>
                                <h3 class="mt-3 text-sm font-semibold text-gray-900">No accounts found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try another search or clear the selected filters.</p>
                                <a href="{{ route('admin.users.index') }}" class="mt-3 inline-flex text-sm font-semibold text-[#b87d49] hover:text-[#9b6236]">Clear filters</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
            <div class="border-t border-gray-200 px-5 py-4">{{ $users->withQueryString()->links() }}</div>
        @endif
    </section>
</div>
@endsection