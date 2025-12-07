<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // list users
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // show create form
    public function create()
    {
        return view('admin.users.create');
    }

    // store new user
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email',
            'role'      => 'required|in:user,admin',
            'is_active' => 'nullable|boolean',
            'password'  => 'nullable|string|min:6|confirmed',
        ]);

        // jika password tidak diisi, buat password random
        $passwordPlain = $request->filled('password') ? $request->password : Str::random(12);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'role'      => $request->role,
            'is_active' => $request->has('is_active') ? (bool) $request->is_active : true,
            'password'  => Hash::make($passwordPlain),
        ]);

        // (opsional) Anda bisa kirim email ke user dengan passwordPlain jika ingin

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // show edit form
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // update role / is_active
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
            'is_active' => 'nullable|boolean',
        ]);

        // proteksi: jangan biarkan admin menurunkan role dirinya sendiri (opsional)
        if (auth()->id() === $user->id && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'Anda tidak boleh mengubah role diri sendiri menjadi non-admin.');
        }

        $user->role = $request->role;
        $user->is_active = $request->has('is_active') ? (bool) $request->is_active : false;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User diperbarui.');
    }

    // delete user
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User dihapus.');
    }
}
