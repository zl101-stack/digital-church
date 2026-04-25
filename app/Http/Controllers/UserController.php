<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'admin') {
            $users = User::where('role', 'user')->get();
            return view('admin.index', compact('users'));
        } else {
            $users = User::where('role', '!=', 'superadmin')->get();
            return view('superadmin.users.index', compact('users'));
        }
    }

    public function create()
    {
        if (auth()->user()->role == 'admin') {
            return view('admin.create');
        }

        return view('superadmin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'role' => 'required'
        ]);

        if (auth()->user()->role == 'admin' && $request->role != 'user') {
            abort(403);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return auth()->user()->role == 'admin'
            ? redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat')
            : redirect()->route('superadmin.users.index')->with('success', 'User berhasil dibuat');
    }

    public function show(User $user)
    {
        if (auth()->user()->role == 'admin') {
            return view('admin.detail', compact('user'));
        }

        return view('superadmin.users.detail', compact('user'));
    }

    public function edit(User $user)
    {
        if (auth()->user()->role == 'admin') {
            return view('admin.edit', compact('user'));
        }

        return view('superadmin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->role == 'admin' && $user->role != 'user') {
            abort(403);
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return auth()->user()->role == 'admin'
            ? redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate')
            : redirect()->route('superadmin.users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'superadmin') {
            abort(403, 'Tidak boleh hapus superadmin');
        }

        if (auth()->user()->role == 'admin' && $user->role != 'user') {
            abort(403);
        }

        $user->delete();

        return auth()->user()->role == 'admin'
            ? redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus')
            : redirect()->route('superadmin.users.index')->with('success', 'User berhasil dihapus');
    }
}