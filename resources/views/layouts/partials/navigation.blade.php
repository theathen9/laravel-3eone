{{-- resources/views/layouts/partials/navigation.blade.php --}}

@php
$user = auth()->user();

$userRoles = collect();

if ($user && method_exists($user, 'roles')) {
$userRoles = $user->roles()
->get()
->map(fn ($role) => $role->role_name ?? $role->name ?? null)
->filter();
}

if ($userRoles->isEmpty() && $user) {
$singleRole = $user->role?->role_name
?? $user->role?->name
?? $user->role_name
?? $user->role
?? null;

if (is_string($singleRole) && $singleRole !== '') {
$userRoles = collect([$singleRole]);
}
}

$userRoles = $userRoles
->map(fn ($role) => strtolower(trim((string) $role)))
->unique()
->values();

// Priority: Admin > Accountant/Account > Teacher
$priority = [
'admin' => 1,
'accountant' => 2,
'account' => 2,
'teacher' => 3,
];

$role = $userRoles
->filter(fn ($role) => isset($priority[$role]))
->sortBy(fn ($role) => $priority[$role])
->first();

$navigationRole = match ($role) {
'admin' => 'admin',
'accountant', 'account' => 'account',
'teacher' => 'teacher',
default => null,
};

$navigation = $navigationRole
? config("navigation.{$navigationRole}", [])
: [];
@endphp

@include('layouts.partials.sidebar', [
'navigation' => $navigation,
'navigationRole' => $navigationRole,
])