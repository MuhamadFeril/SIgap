<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satpam;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SatpamController extends Controller
{
    public function index()
    {
        $satpam = Satpam::with('user')->latest()->get();
        return view('admin.satpam.index', compact('satpam'));
    }

    public function create()
    {
        return view('admin.satpam.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'nip' => 'required|string|max:50|unique:satpam',
            'no_telepon' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'satpam',
            'status' => 'aktif',
        ]);

        Satpam::create([
            'user_id' => $user->id,
            'nip' => $request->nip,
            'no_telepon' => $request->no_telepon,
        ]);

        return redirect()->route('admin.satpam.index')->with('success', 'Satpam berhasil ditambahkan');
    }

    public function show(Satpam $satpam)
    {
        $satpam->load('user');
        return view('admin.satpam.show', compact('satpam'));
    }

    public function edit(Satpam $satpam)
    {
        $satpam->load('user');
        return view('admin.satpam.edit', compact('satpam'));
    }

    public function update(Request $request, Satpam $satpam)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $satpam->user_id,
            'nip' => 'required|string|max:50|unique:satpam,nip,' . $satpam->id,
            'no_telepon' => 'nullable|string|max:20',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $satpam->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ]);

        $satpam->update([
            'nip' => $request->nip,
            'no_telepon' => $request->no_telepon,
        ]);

        if ($request->filled('password')) {
            $satpam->user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('admin.satpam.index')->with('success', 'Satpam berhasil diperbarui');
    }

    public function destroy(Satpam $satpam)
    {
        $satpam->user->delete();
        $satpam->delete();

        return redirect()->route('admin.satpam.index')->with('success', 'Satpam berhasil dihapus');
    }
}
