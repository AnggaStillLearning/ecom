<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
            'role'     => 'user' // Default role
        ]);

        Auth::login($user);

        return redirect('/')->with('success', 'Pendaftaran berhasil! Selamat datang, ' . $user->name);
    }

    /**
     * Proses login pengguna.
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $message = 'Selamat datang kembali, ' . $user->name;

            if ($user->role === 'admin') {
                return redirect('/admin/products')->with('success', $message);
            }

            return redirect('/')->with('success', $message);
        }

        return back()->with('error', 'Email atau password salah.');
    }

    /**
     * Proses logout pengguna.
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah logout.');
    }
}
