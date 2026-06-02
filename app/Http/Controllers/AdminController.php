<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function users()
    {
        $users = User::with('roles')->latest()->get();
        $roles = Role::all();

        return view('admin.users', compact('users', 'roles'));
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        $user->syncRoles([$request->role]);

        return back()->with('success', 'Role user berhasil diperbarui.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->hasRole('admin')) {
            return back()->with('error', 'Tidak dapat menghapus akun admin.');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus.');
    }
}
