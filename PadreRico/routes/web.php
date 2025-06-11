<?php

use App\Http\Controllers\AchivementsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleManager;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\OutcomeController;
use App\Http\Controllers\DefaulterController;
use App\Http\Controllers\DefaultorController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\SavingsObjectiveController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\Auth\VerificationCodeController;
use App\Http\Controllers\ChatBotController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// Rutas protegidas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::view('/cookies', 'cookies')->name('cookies');
    Route::view('/sobre-nosotros', 'sobre-nosotros')->name('sobre-nosotros');
    Route::view('/contacto', 'contacto')->name('contacto');
    Route::post('/contacto/enviar', [ContactoController::class, 'enviar'])->name('contacto.enviar');
});

// Rutas para administradores
Route::middleware(['auth', 'verified', RoleManager::class . ':admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // CRUD de usuarios (para las modales del dashboard)
    Route::post('/admin/users', [AdminController::class, 'store'])->name('users.store');
    Route::put('/admin/users/{user}', [AdminController::class, 'update'])->name('users.update');
    Route::delete('/admin/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});

// Rutas para usuarios
Route::middleware(['auth', 'verified', RoleManager::class . ':user'])->group(function () {
    Route::get('user/dashboard', [UserController::class, 'index'])->name('user.dashboard');

    //Income routes
    Route::get('user/{id}/income', [IncomeController::class, 'index'])->name('income.index');
    Route::delete('user/{id}/income/{idInc}/destroy', [IncomeController::class, 'destroy'])->name('income.destroy');
    Route::get('user/{id}/income/create', [IncomeController::class, 'create'])->name('income.create');
    Route::post('user/{id}/income/store', [IncomeController::class, 'store'])->name('income.store');


    //Outcome routes
    Route::get('user/{id}/outcome', [OutcomeController::class, 'index'])->name('outcome.index');
    Route::get('user/{id}/outcome/create', [OutcomeController::class, 'create'])->name('outcome.create');
    Route::post('user/{id}/outcome/store', [OutcomeController::class, 'store'])->name('outcome.store');
    Route::delete('user/{id}/outcome/{idOut}/destroy', [OutcomeController::class, 'destroy'])->name('outcome.destroy');

    //Defaulter routes 
    Route::get('user/{id}/defaulter', [DefaulterController::class, 'index'])->name('defaulter.index');
    Route::get('user/{id}/defaulter/create', [DefaulterController::class, 'create'])->name('defaulter.create');
    Route::post('user/{id}/defaulter/store', [DefaulterController::class, 'store'])->name('defaulter.store');
    Route::delete('user/{id}/defaulter/{idDef}/destroy', [DefaulterController::class, 'destroy'])->name('defaulter.destroy');
    Route::get('user/{id}/defaulter/{idDef}/show', [DefaulterController::class, 'show'])->name('defaulter.show');

    Route::get('user/{id}/mydebts', [DefaultorController::class, 'index'])->name('defaultors.index');
    Route::post('/defaultors/{id}/accept/{debt}', [DefaultorController::class, 'accept'])->name('defaultors.accept');

    //Statistics routes
    Route::get('user/{id}/statistics/monthly', [StatisticsController::class, 'index_monthly'])->name('statistics.index_monthly');
    Route::get('user/{id}/statistics/weekly', [StatisticsController::class, 'index_weekly'])->name('statistics.index_weekly');

    //savings objectives routes
    Route::get('user/{id}/savings', [SavingsObjectiveController::class, 'index'])->name('savingsobj.index');
    Route::get('user/{id}/savings/create', [SavingsObjectiveController::class, 'create'])->name('savingsobj.create');
    Route::post('user/{id}/savings/store', [SavingsObjectiveController::class, 'store'])->name('savingsobj.store');
    Route::put('/savings_objective/{id}', [SavingsObjectiveController::class, 'update'])->name('savingsobj.update');

    //Achievements routes
    Route::get('user/{id}/achievements', [AchivementsController::class, 'index'])->name('achievements.index');
});
Route::post('/api/chatbot', [ChatBotController::class, 'ask']);

Route::post('/verify-code', [VerificationCodeController::class, 'verify'])->name('verification.code');
Route::post('/resend-code', [VerificationCodeController::class, 'resend'])->name('verification.resend');

require __DIR__ . '/auth.php';
