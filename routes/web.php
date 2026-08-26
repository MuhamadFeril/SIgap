<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\GuruController as AdminGuruController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\SatpamController as AdminSatpamController;
use App\Http\Controllers\Admin\JadwalSatpamController as AdminJadwalSatpamController;
use App\Http\Controllers\Siswa\AuthController as SiswaAuthController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
use App\Http\Controllers\Siswa\PortalController as SiswaPortalController;
use App\Http\Controllers\Siswa\IzinKeluarController as SiswaIzinKeluarController;
use App\Http\Controllers\Guru\AuthController as GuruAuthController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\IzinKeluarController as GuruIzinKeluarController;
use App\Http\Controllers\Satpam\AuthController as SatpamAuthController;
use App\Http\Controllers\Satpam\DashboardController as SatpamDashboardController;
use App\Http\Controllers\Satpam\IzinKeluarController as SatpamIzinKeluarController;
use App\Http\Controllers\Satpam\JadwalSatpamController as SatpamJadwalSatpamController;
use App\Http\Controllers\Satpam\TukarShiftController as SatpamTukarShiftController;

Route::get('/', function () {
    return view('landing');
})->name('landing');

// Unified Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboard', [SiswaPortalController::class, 'index'])->name('user.dashboard');
    Route::post('/dashboard/izin', [SiswaPortalController::class, 'store'])->name('user.izin.store');
    Route::patch('/dashboard/profil', [SiswaPortalController::class, 'updateProfile'])->name('user.profile.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function() {
    Route::middleware('guest')->group(function () {
        // Keep old links working while using the single public authentication flow.
        Route::get('login', fn () => redirect()->route('login'))->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::get('register', fn () => redirect()->route('register'))->name('register');
        Route::post('register', [AuthController::class, 'register']);
    });

    Route::middleware('auth')->group(function () {
        Route::middleware('role:admin')->group(function () {
            Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        });
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        // Guru management routes
        Route::prefix('guru')->name('guru.')->group(function () {
            Route::get('/', [AdminGuruController::class, 'index'])->name('index');
            Route::get('/create', [AdminGuruController::class, 'create'])->name('create');
            Route::post('/', [AdminGuruController::class, 'store'])->name('store');
            Route::get('/{guru}', [AdminGuruController::class, 'show'])->name('show');
            Route::get('/{guru}/edit', [AdminGuruController::class, 'edit'])->name('edit');
            Route::put('/{guru}', [AdminGuruController::class, 'update'])->name('update');
            Route::delete('/{guru}', [AdminGuruController::class, 'destroy'])->name('destroy');
        });

        // Siswa management routes
        Route::prefix('siswa')->name('siswa.')->group(function () {
            Route::get('/', [AdminSiswaController::class, 'index'])->name('index');
            Route::get('/create', [AdminSiswaController::class, 'create'])->name('create');
            Route::post('/', [AdminSiswaController::class, 'store'])->name('store');
            Route::get('/{siswa}', [AdminSiswaController::class, 'show'])->name('show');
            Route::get('/{siswa}/edit', [AdminSiswaController::class, 'edit'])->name('edit');
            Route::put('/{siswa}', [AdminSiswaController::class, 'update'])->name('update');
            Route::delete('/{siswa}', [AdminSiswaController::class, 'destroy'])->name('destroy');
        });

        // Satpam management routes
        Route::prefix('satpam')->name('satpam.')->group(function () {
            Route::get('/', [AdminSatpamController::class, 'index'])->name('index');
            Route::get('/create', [AdminSatpamController::class, 'create'])->name('create');
            Route::post('/', [AdminSatpamController::class, 'store'])->name('store');
            Route::get('/{satpam}', [AdminSatpamController::class, 'show'])->name('show');
            Route::get('/{satpam}/edit', [AdminSatpamController::class, 'edit'])->name('edit');
            Route::put('/{satpam}', [AdminSatpamController::class, 'update'])->name('update');
            Route::delete('/{satpam}', [AdminSatpamController::class, 'destroy'])->name('destroy');
        });

        // Jadwal Satpam management routes
        Route::prefix('jadwal')->name('jadwal.')->group(function () {
            Route::get('/', [AdminJadwalSatpamController::class, 'index'])->name('index');
            Route::get('/create', [AdminJadwalSatpamController::class, 'create'])->name('create');
            Route::post('/', [AdminJadwalSatpamController::class, 'store'])->name('store');
            Route::get('/{jadwalSatpam}/edit', [AdminJadwalSatpamController::class, 'edit'])->name('edit');
            Route::put('/{jadwalSatpam}', [AdminJadwalSatpamController::class, 'update'])->name('update');
            Route::delete('/{jadwalSatpam}', [AdminJadwalSatpamController::class, 'destroy'])->name('destroy');
        });
    });
});

// Siswa Routes
Route::prefix('siswa')->name('siswa.')->group(function() {
    Route::middleware('auth')->group(function () {
        Route::middleware('role:siswa')->group(function () {
            Route::get('dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

            // Izin Keluar routes
            Route::prefix('izin-keluar')->name('izin_keluar.')->group(function () {
                Route::get('/', [SiswaIzinKeluarController::class, 'index'])->name('index');
                Route::get('/create', [SiswaIzinKeluarController::class, 'create'])->name('create');
                Route::post('/', [SiswaIzinKeluarController::class, 'store'])->name('store');
                Route::get('/{izinKeluar}', [SiswaIzinKeluarController::class, 'show'])->name('show');
                Route::delete('/{izinKeluar}', [SiswaIzinKeluarController::class, 'destroy'])->name('destroy');
            });
        });
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// Guru Routes
Route::prefix('guru')->name('guru.')->group(function() {
    Route::middleware('auth')->group(function () {
        Route::middleware('role:guru')->group(function () {
            Route::get('dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');
        Route::prefix('izin-keluar')->name('izin_keluar.')->group(function () {
            Route::get('/', [GuruIzinKeluarController::class, 'index'])->name('index');
            Route::get('/{izinKeluar}', [GuruIzinKeluarController::class, 'show'])->name('show');
            Route::post('/{izinKeluar}/approve', [GuruIzinKeluarController::class, 'approve'])->name('approve');
            Route::post('/{izinKeluar}/reject', [GuruIzinKeluarController::class, 'reject'])->name('reject');
        });
        });
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});

// Satpam Routes
Route::prefix('satpam')->name('satpam.')->group(function() {
    Route::middleware('auth')->group(function () {
        Route::middleware('role:satpam')->group(function () {
            Route::get('dashboard', [SatpamDashboardController::class, 'index'])->name('dashboard');
            Route::post('presensi', [SatpamJadwalSatpamController::class, 'presensiHariIni'])->name('presensi');

            // Izin Keluar routes
            Route::prefix('izin-keluar')->name('izin_keluar.')->group(function () {
                Route::get('/', [SatpamIzinKeluarController::class, 'index'])->name('index');
                Route::post('/{izinKeluar}/tandai-keluar', [SatpamIzinKeluarController::class, 'tandaiKeluar'])->name('tandai_keluar');
                Route::post('/{izinKeluar}/tandai-kembali', [SatpamIzinKeluarController::class, 'tandaiKembali'])->name('tandai_kembali');
                Route::get('/keluar-hari-ini', [SatpamIzinKeluarController::class, 'keluarHariIni'])->name('keluar_hari_ini');
                Route::get('/riwayat', [SatpamIzinKeluarController::class, 'riwayat'])->name('riwayat');
            });

            // Jadwal Satpam routes
            Route::prefix('jadwal')->name('jadwal.')->group(function () {
                Route::get('/', [SatpamJadwalSatpamController::class, 'index'])->name('index');
                Route::post('/{jadwalSatpam}/presensi-masuk', [SatpamJadwalSatpamController::class, 'presensiMasuk'])->name('presensi_masuk');
                Route::post('/{jadwalSatpam}/presensi-pulang', [SatpamJadwalSatpamController::class, 'presensiPulang'])->name('presensi_pulang');
                Route::get('/riwayat', [SatpamJadwalSatpamController::class, 'riwayat'])->name('riwayat');
            });

            // Tukar Shift routes
            Route::prefix('tukar-shift')->name('tukar_shift.')->group(function () {
                Route::get('/', [SatpamTukarShiftController::class, 'index'])->name('index');
                Route::get('/create', [SatpamTukarShiftController::class, 'create'])->name('create');
                Route::post('/', [SatpamTukarShiftController::class, 'store'])->name('store');
                Route::get('/permintaan-masuk', [SatpamTukarShiftController::class, 'permintaanMasuk'])->name('permintaan_masuk');
                Route::get('/{tukarShift}', [SatpamTukarShiftController::class, 'show'])->name('show');
                Route::delete('/{tukarShift}', [SatpamTukarShiftController::class, 'destroy'])->name('destroy');
                Route::post('/{tukarShift}/approve', [SatpamTukarShiftController::class, 'approve'])->name('approve');
                Route::post('/{tukarShift}/reject', [SatpamTukarShiftController::class, 'reject'])->name('reject');
            });
        });
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
