<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AccessControlController extends Controller
{
    public function users(Request $request): View
    {
        $query = User::query()->with('role');
        $search = $request->input('search');
        $search = is_string($search) ? trim($search) : '';
        $status = (string) $request->input('status', '');
        $roleId = $request->input('role_id');

        if ($search !== '') {
            $term = '%' . mb_strtolower($search) . '%';

            $query->where(function ($builder) use ($term) {
                $builder->whereRaw('LOWER(username) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(email) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(reference_code) LIKE ?', [$term]);
            });
        }

        if (in_array($status, ['0', '1'], true)) {
            $query->where('status', (int) $status);
        }

        if (is_string($roleId) && ctype_digit($roleId)) {
            $query->where('role_id', (int) $roleId);
        }

        $users = $query
            ->orderBy('username')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::query()->orderBy('role_name')->get(['role_id', 'role_name']),
            'search' => $search,
            'status' => $status,
            'roleId' => $roleId,
            'totalUsers' => User::count(),
            'activeUsers' => User::where('status', 1)->count(),
            'inactiveUsers' => User::where('status', 0)->count(),
            'totalRoles' => Role::count(),
        ]);
    }

    public function roles(Request $request): View
    {
        $query = Role::query()
            ->with('permissions')
            ->withCount(['users', 'permissions']);
        $search = $request->input('search');
        $search = is_string($search) ? trim($search) : '';

        if ($search !== '') {
            $term = '%' . mb_strtolower($search) . '%';

            $query->where(function ($builder) use ($term) {
                $builder->whereRaw('LOWER(role_name) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$term]);
            });
        }

        $roles = $query
            ->orderBy('role_name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.roles.index', [
            'roles' => $roles,
            'search' => $search,
            'totalRoles' => Role::count(),
            'assignedUsers' => User::whereNotNull('role_id')->count(),
            'totalPermissions' => Permission::count(),
        ]);
    }

    public function permissions(Request $request): View
    {
        $query = Permission::query()
            ->with('roles')
            ->withCount('roles');
        $search = $request->input('search');
        $search = is_string($search) ? trim($search) : '';

        if ($search !== '') {
            $term = '%' . mb_strtolower($search) . '%';

            $query->where(function ($builder) use ($term) {
                $builder->whereRaw('LOWER(permission_name) LIKE ?', [$term])
                    ->orWhereRaw('LOWER(description) LIKE ?', [$term]);
            });
        }

        $permissions = $query
            ->orderBy('permission_name')
            ->paginate(12)
            ->withQueryString();

        return view('admin.users.permissions.index', [
            'permissions' => $permissions,
            'search' => $search,
            'totalPermissions' => Permission::count(),
            'rolesWithAccess' => Role::has('permissions')->count(),
            'unassignedPermissions' => Permission::doesntHave('roles')->count(),
        ]);
    }
}
