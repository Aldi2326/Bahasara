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
        // 1. Definisikan Rules (Aturan)
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:user,email', // Pastikan nama tabel di database 'user' atau 'users'
            'password' => [
                'required',
                'confirmed', // Membutuhkan field 'password_confirmation' di form
                Password::min(8)
                    ->letters()    // Harus ada huruf
                    ->mixedCase()  // Harus ada huruf besar & kecil
                    ->numbers()    // Harus ada angka
                    ->symbols(),   // Harus ada simbol (@$!%*#?&)
            ],
            'role' => 'required|in:superadmin,admin,pegawai',
        ];

        // 2. Definisikan Pesan Error (Bahasa Indonesia)
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar, gunakan email lain.',
            
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Password tidak sesuai dengan konfirmasi password.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.letters'   => 'Kata sandi harus gabungan huruf besar dan kecil, mengandung angka, simbol (misal: @, #, !).',
            'password.mixed'     => 'Kata sandi harus gabungan huruf besar dan kecil, mengandung angka, simbol (misal: @, #, !).',
            'password.numbers'   => 'Kata sandi harus gabungan huruf besar dan kecil, mengandung angka, simbol (misal: @, #, !).',
            'password.symbols'   => 'Kata sandi harus gabungan huruf besar dan kecil, mengandung angka, simbol (misal: @, #, !).',
            
            // Pesan untuk role
            'role.required' => 'Role (Peran) wajib dipilih.',
            'role.in' => 'Pilihan role tidak valid.',
        ];

        // 3. Jalankan Validasi
        $request->validate($rules, $messages);

        // 4. Simpan Data
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // 5. Redirect
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

        $rules = [
            'name' => 'required|string|max:255',
            
            // PERBAIKAN 1: Ignore email milik user yang sedang diedit
            'email' => 'required|email|unique:user,email,'.$id, 
            
            // PERBAIKAN 2: Ubah 'required' jadi 'nullable'
            'password' => [
                'nullable', // Boleh kosong jika tidak ingin ganti password
                'confirmed', 
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ],
            'role' => 'required|in:superadmin,admin,pegawai',
        ];

        // 2. Definisikan Pesan Error (Bahasa Indonesia)
        $messages = [
            'name.required' => 'Nama lengkap wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar, gunakan email lain.',
            
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Password tidak sesuai dengan konfirmasi password.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.letters'   => 'Kata sandi harus gabungan huruf besar dan kecil, mengandung angka, simbol (misal: @, #, !).',
            'password.mixed'     => 'Kata sandi harus gabungan huruf besar dan kecil, mengandung angka, simbol (misal: @, #, !).',
            'password.numbers'   => 'Kata sandi harus gabungan huruf besar dan kecil, mengandung angka, simbol (misal: @, #, !).',
            'password.symbols'   => 'Kata sandi harus gabungan huruf besar dan kecil, mengandung angka, simbol (misal: @, #, !).',
            
            // Pesan untuk role
            'role.required' => 'Role (Peran) wajib dipilih.',
            'role.in' => 'Pilihan role tidak valid.',
        ];

        $request->validate($rules, $messages);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            // Jika diisi, hash password dan masukkan ke array data
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

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

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        
        if ($ids) {
            $idsArray = explode(',', $ids);
            
            // Hapus data DENGAN PENGECUALIAN role superadmin
            // Ini penting untuk keamanan backend jika seseorang memanipulasi HTML
            $deleted = User::whereIn('id', $idsArray)
                ->where('role', '!=', 'superadmin') 
                ->delete();
            
            if ($deleted) {
                return redirect()->back()->with('success', 'Data pengguna terpilih berhasil dihapus.');
            } else {
                return redirect()->back()->with('error', 'Tidak ada data yang dihapus (Mungkin data yang dipilih adalah Superadmin).');
            }
        }
        
        return redirect()->back()->with('error', 'Tidak ada data yang dipilih.');
    }
}