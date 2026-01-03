<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        // Ambil query pencarian dari input (jika ada)
        $search = $request->input('search');

        // Query dasar: hanya tampilkan superadmin, admin, dan pegawai
        $user = User::whereIn('role', ['superadmin', 'admin', 'pegawai'])
            ->when($search, function ($query, $search) {
                // Tambahkan filter pencarian berdasarkan nama, email, atau role
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('role', 'like', "%{$search}%");
                });
            })
            ->get();

        return view('pages.admin.pengguna.index', compact('user', 'search'));
    }

    public function create()
    {
        return view('pages.admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:superadmin,admin,pegawai',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('pengguna.index')->with('success');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.admin.pengguna.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'role' => 'required|in:superadmin,admin,pegawai',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('pengguna.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id() && $user->role === 'superadmin') {
            abort(403, 'Super admin tidak boleh menghapus dirinya sendiri');
        }

        if (
            $user->role === 'superadmin' &&
            User::where('role', 'superadmin')->count() <= 1
        ) {
            abort(403, 'Minimal harus ada satu super admin');
        }

        $user->delete();

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
