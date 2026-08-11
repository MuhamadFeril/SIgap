<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    public function index()
    {
        $guru = Guru::with('user')->latest()->get();
        return view('admin.guru.index', compact('guru'));
    }

    public function create()
    {
        return view('admin.guru.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|max:50|unique:guru',
            'mapel' => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru',
            'status' => 'aktif',
        ]);

        Guru::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'mapel' => $request->mapel,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil ditambahkan');
    }

    public function show(Guru $guru)
    {
        $guru->load('user');
        return view('admin.guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        $guru->load('user');
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $guru->user_id,
            'nip' => 'required|string|max:50|unique:guru,nip,' . $guru->id,
            'mapel' => 'required|string|max:100',
            'no_telepon' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $guru->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        $guru->update([
            'nip' => $request->nip,
            'mapel' => $request->mapel,
            'no_telepon' => $request->no_telepon,
        ]);

        if ($request->filled('password')) {
            $guru->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil diperbarui');
    }

    public function destroy(Guru $guru)
    {
        $guru->user->delete();
        $guru->delete();

        return redirect()->route('admin.guru.index')->with('success', 'Guru berhasil dihapus');
    }
}
