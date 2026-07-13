<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of admin users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        $users = $query->with('roles')->latest()->paginate($request->input('per_page', 10))
            ->withQueryString();

        $allRoles = Role::where('guard_name', 'admin')->get();

        if ($request->ajax()) {
            return view('admin.users._table', compact('users'))->render();
        }

        return view('admin.users.index', [
            'users' => $users,
            'filters' => $request->only(['search', 'status', 'per_page']),
            'allRoles' => $allRoles,
        ]);
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'is_active' => 'nullable|boolean',
            'role'     => 'nullable|string|exists:Spatie\Permission\Models\Role,name',
        ]);

        $validated['password'] = bcrypt($validated['password']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $user = User::create($validated);

        // Assign role (default: admin)
        $roleName = $validated['role'] ?? 'admin';
        $user->assignRole($roleName);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'is_active' => 'nullable|boolean',
            'role'     => 'nullable|string|exists:Spatie\Permission\Models\Role,name',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['is_active'] = $request->boolean('is_active', true);

        $user->update($validated);

        // Sync role
        if ($request->filled('role')) {
            $user->syncRoles([$validated['role']]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Toggle user active status.
     */
    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'is_active' => 'required|boolean',
        ]);

        // Prevent self-deactivation
        if ((int) $user->id === (int) auth()->guard('admin')->id() && !$validated['is_active']) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $user->update($validated);

        return redirect()->back()
            ->with('success', 'Status pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent self-deletion
        if ((int) $user->id === (int) auth()->guard('admin')->id()) {
            return redirect()->back()
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
