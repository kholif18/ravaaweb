<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display role & permission info page.
     */
    public function index()
    {
        $roles = Role::where('guard_name', 'admin')
            ->with('permissions')
            ->get()
            ->map(function ($role) {
                $role->users_count = $role->users()->count();
                return $role;
            });

        $allPermissions = Permission::where('guard_name', 'admin')->get();
        $totalUsers = \App\Models\User::count();

        return view('admin.roles.index', compact('roles', 'allPermissions', 'totalUsers'));
    }
}
