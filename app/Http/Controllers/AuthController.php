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
            'email' => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email, NIS, atau NIP wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $input = trim($validated['email']);
        $password = $validated['password'];
        $remember = $request->boolean('remember');

        // Cari user berdasarkan Email, NIS (Siswa), atau NIP (Guru/Satpam)
        $user = User::where('email', $input)->first();

        if (!$user) {
            $siswa = Siswa::where('nis', $input)->first();
            if ($siswa && $siswa->user) {
                $user = $siswa->user;
            }
        }

        if (!$user) {
            $guru = \App\Models\Guru::where('nip', $input)->first();
            if ($guru && $guru->user) {
                $user = $guru->user;
            }
        }

        if (!$user) {
            $satpam = \App\Models\Satpam::where('nip', $input)->first();
            if ($satpam && $satpam->user) {
                $user = $satpam->user;
            }
        }

        $emailToAttempt = $user ? $user->email : $input;

        $credentials = [
            'email' => $emailToAttempt,
            'password' => $password,
        ];

        if (!Auth::attempt($credentials, $remember)) {
            return back()
                ->withErrors([
                    'email' => 'Email / NIS / NIP atau kata sandi yang Anda masukkan salah.',
                ])
                ->withInput([
                    'email' => $input,
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
                    'email' => $input,
                ]);
        }

        $request->session()->regenerate();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.dashboard');

            case 'guru':
                return redirect()->route('guru.dashboard');

            case 'siswa':
            case 'user': // legacy role — treat as siswa
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