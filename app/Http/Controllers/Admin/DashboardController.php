<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Guru;
use App\Models\Satpam;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $totalGuru = Guru::count();
            $totalSiswa = Siswa::count();
            $totalSatpam = Satpam::count();
            $totalUsers = User::count();
            $guruAktif = Guru::whereHas('user', function($query) {
                $query->where('status', 'aktif');
            })->count();
            $siswaAktif = Siswa::whereHas('user', function($query) {
                $query->where('status', 'aktif');
            })->count();
            $satpamAktif = Satpam::whereHas('user', function($query) {
                $query->where('status', 'aktif');
            })->count();

            return view('admin.dashboard', compact(
                'totalGuru',
                'totalSiswa',
                'totalSatpam',
                'totalUsers',
                'guruAktif',
                'siswaAktif',
                'satpamAktif'
            ));
        } catch (\Exception $e) {
            return view('admin.dashboard', [
                'totalGuru' => 0,
                'totalSiswa' => 0,
                'totalSatpam' => 0,
                'totalUsers' => 0,
                'guruAktif' => 0,
                'siswaAktif' => 0,
                'satpamAktif' => 0,
                'error' => $e->getMessage()
            ]);
        }
    }
}
