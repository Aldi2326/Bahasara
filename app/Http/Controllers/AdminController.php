<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $user = User::whereIn('role', ['superadmin', 'admin', 'pegawai'])
            ->when($search, function ($query, $search) {
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
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'role' => 'required|in:superadmin,admin,pegawai',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
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
            'password' => [
                'nullable',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'role' => 'required|in:superadmin,admin,pegawai',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id() && $user->role === 'superadmin') {
            abort(403, 'Super admin tidak boleh menghapus dirinya sendiri.');
        }

        if (
            $user->role === 'superadmin' &&
            User::where('role', 'superadmin')->count() <= 1
        ) {
            abort(403, 'Minimal harus ada satu super admin.');
        }

        $user->delete();

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}