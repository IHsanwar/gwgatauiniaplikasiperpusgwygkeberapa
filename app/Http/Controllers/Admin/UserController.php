<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    public function index()
{
    $users = User::all();
    return view('admin.users.index', compact('users'));
}

public function toggleRole(User $user)
{
    $newRole = $user->role === 'admin' ? 'user' : 'admin';
    $user->update(['role' => $newRole]);
    return back()->with('success', 'Peran pengguna diperbarui.');
}
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,user,petugas',
        ]);

        $user = User::findOrFail($id);
        $user->update($request->only('name', 'email', 'role'));

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
