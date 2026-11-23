@extends('layouts.admin')

@section('title', 'Permissions | 3EONE')

@section('content')
<div class="mx-auto w-full max-w-screen-2xl space-y-6">
    <header>
        <p class="mb-2 text-xs font-semibold uppercase tracking-[0.18em] text-[#b87d49]">Access management</p>
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Permissions</h1>
        <p class="mt-1 text-sm text-gray-500">Review the capabilities granted to each role.</p>
    </header>

    <nav aria-label="Access management" class="flex gap-1 overflow-x-auto rounded-xl border border-gray-200 bg-white p-1.5 shadow-sm">
        <a href="{{ route('admin.users.index') }}" class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">Users</a>
        <a href="{{ route('admin.roles.index') }}" class="whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-100 hover:text-gray-900">Roles</a>
        <a href="{{ route('admin.permissions.index') }}" aria-current="page" class="whitespace-nowrap rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white">Permissions</a>
    </nav>

    <section aria-label="Permission statistics" class="grid gap-4 sm:grid-cols-3">
        <article class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Defined permissions</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900">{{ number_format($totalPermissions) }}</p>
        </article>
        <article class="rounded-xl border border-emerald-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Roles with access</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-emerald-700">{{ number_format($rolesWithAccess) }}</p>
        </article>
        <article class="rounded-xl border border-amber-100 bg-white p-5 shadow-sm">
            <p class="text-sm font-medium text-gray-500">Unassigned permissions</p>
            <p class="mt-2 text-3xl font-bold tracking-tight text-amber-700">{{ number_format($unassignedPermissions) }}</p>
        </article>
    </section>

    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="flex flex-col gap-4 border-b border-gray-200 px-5 py-5 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="text-base font-semibold text-gray-900">Permission directory</h2>
                <p class="mt-1 text-sm text-gray-500">{{ number_format($permissions->total()) }} matching permissions</p>
            </div>
            <form method="GET" action="{{ route('admin.permissions.index') }}" class="flex w-full gap-2 sm:w-auto">
                <label class="sr-only" for="permissionSearch">Search permissions</label>
                <input id="permissionSearch" type="search" name="search" value="{{ $search }}" placeholder="Search permission or description"
                    class="min-w-0 flex-1 rounded-lg border border-gray-300 px-3.5 py-2.5 text-sm outline-none transition placeholder:text-gray-400 focus:border-[#d1935c] focus:ring-4 focus:ring-orange-100 sm:w-80">
                <button type="submit" class="rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-700">Search</button>
                @if ($search !== '')
                    <a href="{{ route('admin.permissions.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-600 transition hover:bg-gray-50">Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Permission</th>
                        <th scope="col" class="px-4 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Description</th>
                        <th scope="col" class="px-5 py-3 text-xs font-semibold uppercase tracking-wider text-gray-500">Assigned roles</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($permissions as $permission)
                        <tr class="align-top transition hover:bg-gray-50">
                            <td class="px-5 py-4">
                                <span class="inline-flex rounded-md border border-violet-100 bg-violet-50 px-2.5 py-1.5 font-mono text-xs font-semibold text-violet-700">{{ $permission->permission_name }}</span>
                            </td>
                            <td class="max-w-md px-4 py-4 text-sm text-gray-600">{{ $permission->description ?: 'No description provided.' }}</td>
                            <td class="px-5 py-4">
                                @if ($permission->roles->isEmpty())
                                    <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700">Unassigned</span>
                                @else
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach ($permission->roles->take(4) as $role)
                                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-medium text-gray-600">{{ $role->role_name }}</span>
                                        @endforeach
                                        @if ($permission->roles_count > 4)
                                            <span class="rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-600">+{{ $permission->roles_count - 4 }} more</span>
                                        @endif
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-5 py-16 text-center">
                                <h3 class="text-sm font-semibold text-gray-900">No permissions found</h3>
                                <p class="mt-1 text-sm text-gray-500">Try a different search term or clear the filter.</p>
                                <a href="{{ route('admin.permissions.index') }}" class="mt-3 inline-flex text-sm font-semibold text-[#b87d49] hover:text-[#9b6236]">Clear search</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($permissions->hasPages())
            <div class="border-t border-gray-200 px-5 py-4">{{ $permissions->withQueryString()->links() }}</div>
        @endif
    </section>
</div>
@endsection