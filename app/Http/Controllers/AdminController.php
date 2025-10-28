<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return view('pages.admin.pengguna.index', compact('admins'));
    }

    public function create()
    {
        return view('pages.admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin', // otomatis admin biasa
        ]);

        return redirect()->back()->with('success', 'Akun admin berhasil ditambahkan!');
    }

    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('pages.admin.pengguna.index')->with('success', 'Admin berhasil dihapus.');
    }
}
