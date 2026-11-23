@extends('layouts.admin')

@section('title', 'Roles | 3EONE')

@section('content')
<div class="mx-auto w-full max-w-screen-2xl space-y-6">
    <header>
        <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#b87d49]">Access management</p>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Roles</h1>
        <p class="mt-1 text-sm text-gray-500">Understand how account groups map to users and permissions.</p>
    </header>

    <nav aria-label="Access management" class="flex gap-1 overflow-x-auto rounded-xl border border-gray-200 bg-white p-1.5 shadow-sm">
        <a href="{{ route('admin.users.index') }}" class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">Users</a>
        <a href="{{ route('admin.roles.index') }}" aria-current="page" class="whitespace-nowrap rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white">Roles</a>
        <a href="{{ route('admin.permissions.index') }}" class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">Permissions</a>
    </nav>

    <section aria-label="Role statistics" class="grid gap-4 sm:grid-cols-3">
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Defined roles</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($totalRoles) }}</p>
        </article>
        <article class="rounded-xl border border-blue-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Users with roles</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-blue-700">{{ number_format($assignedUsers) }}</p>
        </article>
        <article class="rounded-xl border border-violet-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Available permissions</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-violet-700">{{ number_format($totalPermissions) }}</p>
            <a href="{{ route('admin.permissions.index') }}" class="mt-1 inline-flex text-xs font-semibold text-violet-700 hover:text-violet-900">Explore permissions <span aria-hidden="true" class="ml-1">→</span></a>
        </article>
    </section>

    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Role directory</h2>
                <p class="mt-1 text-sm text-gray-500">{{ number_format($roles->total()) }} matching roles</p>
            </div>
            <form method="GET" action="{{ route('admin.roles.index') }}" class="flex w-full gap-2 sm:w-auto">
                <label class="sr-only" for="roleSearch">Search roles</label>
                <input id="roleSearch" type="search" name="search" value="{{ $search }}" placeholder="Search role or description"
                    class="min-w-0 flex-1 rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm outline-none transition placeholder:text-gray-400 focus:border-[#d1935c] focus:ring-4 focus:ring-orange-100 sm:w-72">
                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">Search</button>
                @if ($search !== '')
                    <a href="{{ route('admin.roles.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[780px] text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Role</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Users</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Permissions</th>
                        <th scope="col" class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-gray-500">Access</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($roles as $role)
                        <tr class="align-top transition hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <p class="text-sm font-semibold text-gray-900">{{ $role->role_name }}</p>
                                <p class="mt-1 max-w-md text-sm text-gray-500">{{ $role->description ?: 'No description provided.' }}</p>
                            </td>
                            <td class="px-4 py-4">
                                <span class="inline-flex min-w-9 justify-center rounded-lg bg-blue-50 px-2.5 py-1.5 text-sm font-semibold text-blue-700">{{ number_format($role->users_count) }}</span>
                            </td>
                            <td class="px-4 py-4">
                                @if ($role->permissions->isEmpty())
                                    <span class="text-sm text-gray-400">No permissions assigned</span>
                                @else
                                    <div class="flex max-w-lg flex-wrap gap-1.5">
                                        @foreach ($role->permissions->take(4) as $permission)
                                            <span class="rounded-md border border-gray-200 bg-white px-2 py-1 text-xs font-medium text-gray-600">{{ $permission->permission_name }}</span>
                                        @endforeach
                                        @if ($role->permissions_count > 4)
                                            <span class="rounded-md bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-600">+{{ $role->permissions_count - 4 }} more</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('admin.permissions.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-[#b87d49] hover:text-[#9b6236]">
                                    View permissions <span aria-hidden="true">→</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-16 text-center">
                                <h3 class="text-sm font-semibold text-gray-900">No roles found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try another search term or clear the filter.</p>
                                <a href="{{ route('admin.roles.index') }}" class="mt-3 inline-flex text-sm font-semibold text-[#b87d49] hover:text-[#9b6236]">Clear search</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($roles->hasPages())
            <div class="border-t border-gray-200 px-5 py-4">{{ $roles->withQueryString()->links() }}</div>
        @endif
    </section>
</div>
@endsection