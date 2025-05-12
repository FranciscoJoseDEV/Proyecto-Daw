<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleManager;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutcomeController;

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
    Route::get('user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    //Income routes
    Route::get('user/{id}/income', [IncomeController::class, 'index'])->name('income.index');
    Route::get('user/{id}/income/create', [IncomeController::class, 'create'])->name('income.create');
    Route::post('user/{id}/income/store', [IncomeController::class, 'store'])->name('income.store');
    Route::delete('user/{id}/income/{idInc}/destroy', [IncomeController::class, 'destroy'])->name('income.destroy');

    //Outcome routes
    Route::get('user/{id}/outcome', [OutcomeController::class, 'index'])->name('outcome.index');
    Route::get('user/{id}/outcome/create', [OutcomeController::class, 'create'])->name('outcome.create');
    Route::post('user/{id}/outcome/store', [OutcomeController::class, 'store'])->name('outcome.store');
    Route::delete('user/{id}/outcome/{idOut}/destroy', [OutcomeController::class, 'destroy'])->name('outcome.destroy');
});

require __DIR__ . '/auth.php';
