<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleManager;
use App\Http\Controllers\TrueLayerController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rutas protegidas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas para administradores
Route::middleware(['auth', 'verified', RoleManager::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

// Rutas para usuarios
Route::middleware(['auth', 'verified', RoleManager::class . ':user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('dashboard');
    })->name('user.dashboard');
});

Route::get('/truelayer/connect', [TrueLayerController::class, 'redirectToTrueLayer'])->name('truelayer.connect');
Route::get('/truelayer/callback', [TrueLayerController::class, 'handleCallback'])->name('truelayer.callback');
Route::get('/truelayer/accounts', [TrueLayerController::class, 'getAccounts'])->name('truelayer.accounts');
Route::get('/truelayer/accounts/{accountId}/transactions', [TrueLayerController::class, 'getTransactions'])->name('truelayer.transactions');

require __DIR__ . '/auth.php';
