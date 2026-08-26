<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
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
            'nis' => 'required|string|max:50|unique:siswa,nis',
            'kelas' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'siswa',
            'status' => 'aktif',
        ]);

        Siswa::create([
            'user_id' => $user->id,
            'nis' => $validated['nis'],
            'kelas' => $validated['kelas'],
        ]);

        return redirect()
            ->route('login')
            ->with('status', 'Pendaftaran berhasil. Silakan masuk menggunakan akun Anda.');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => $validated['email'],
            'password' => $validated['password'],
        ];

        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors([
                    'email' => 'Email atau kata sandi yang Anda masukkan salah.',
                ])
                ->withInput([
                    'email' => $request->email,
                ]);
        }

        $user = Auth::user();

        if ($user->status !== 'aktif') {
            Auth::logout();

            return back()
                ->withErrors([
                    'email' => 'Akun Anda tidak aktif. Silakan hubungi admin.',
                ])
                ->withInput([
                    'email' => $request->email,
                ]);
        }

        $request->session()->regenerate();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'guru':
                return redirect()->route('guru.dashboard');

            case 'siswa':
                return redirect()->route('siswa.dashboard');

            case 'satpam':
                return redirect()->route('satpam.dashboard');

            default:
                Auth::logout();

                return redirect()
                    ->route('login')
                    ->withErrors([
                        'email' => 'Role akun tidak dikenali.',
                    ]);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}