<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('pages.admin.login');
    }

    public function login(Request $request)
    {
        // Validasi input (pakai name, bukan email)
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek kredensial pakai name
        if (Auth::attempt($request->only('name', 'password'))) {
            $request->session()->regenerate();
            return redirect()->intended('/admin/dashboard')->with('success', 'Login berhasil!');
        }

        return back()->withErrors([
            'name' => 'Username atau password salah.',
        ])->onlyInput('name');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login')->with('success', 'Anda telah logout.');
    }
}
