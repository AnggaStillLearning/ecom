<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Tampilkan halaman registrasi.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses registrasi pengguna baru.
     */
    public function register(Request $request)
    {
        // Validasi input user
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        // Buat user baru dan hash password-nya
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user' // Role default adalah user biasa
        ]);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect ke halaman utama
        return redirect('/');
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        // Ambil kredensial dari form
        $credentials = $request->only('email', 'password');

        // Coba login menggunakan Auth::attempt
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Cek role pengguna
            if ($user->role === 'admin') {
                return redirect('/admin/products');
            }

            // Redirect default untuk role lain (user/pembeli)
            return redirect('/');
        }

        // Jika gagal login, kembali dengan error
        return back()->withErrors([
            'email' => 'Email atau password salah'
        ]);
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request)
    {
        // Logout user
        auth()->logout();

        // Invalidate dan regenerate session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke beranda dengan pesan sukses
        return redirect('/')->with('success', 'Berhasil logout');
    }
}
