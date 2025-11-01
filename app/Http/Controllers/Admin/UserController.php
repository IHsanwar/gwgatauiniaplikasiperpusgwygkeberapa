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
}
