<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.form', ['mode' => 'login']);
    }

    public function showRegistrationForm()
    {
        return view('auth.form', ['mode' => 'register']);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
            'status' => 'aktif',
        ]);

        return redirect()->route('login')->with('status', 'Pendaftaran berhasil. Silakan masuk menggunakan akun Anda.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Check if user is active
            if ($user->status !== 'aktif') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi admin.',
                ])->withInput(['email' => $request->email]);
            }

            $request->session()->regenerate();

            // Redirect based on role
            return match($user->role) {
                'admin' => redirect()->intended(route('admin.dashboard')),
                'guru' => redirect()->intended(route('guru.dashboard')),
                'siswa' => redirect()->intended(route('siswa.dashboard')),
                'satpam' => redirect()->intended(route('satpam.dashboard')),
                'user' => redirect()->intended(route('user.dashboard')),
                default => redirect()->route('landing'),
            };
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi yang Anda masukkan salah.',
        ])->withInput(['email' => $request->email]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
