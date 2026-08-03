<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
Route::get('/', function () {
    return view('landing');
});
Route::prefix('admin')->name('admin.')->group(function() {
    Route::middleware('guest')->group(function () {
        Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [AuthController::class, 'register']);
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
    });

});
    
    
