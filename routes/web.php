<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountController;

use App\Http\Controllers\Admin\HomeController as AdminHome;
use App\Http\Controllers\Docente\HomeController as DocenteHome;

use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\PersonaController;
use App\Http\Controllers\RolPermisoController;
use App\Http\Controllers\Admin\DocenteController;
use App\Http\Controllers\Admin\AdministrativoController;

// Auth

Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // 👈 nombre exacto: login
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
//Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ⬇️ Redirige la raíz al login
Route::redirect('/', '/login');

// Dashboards + CRUD protegidos por rol
Route::middleware(['auth','role:administrador'])->group(function () {
    Route::get('/admin', [\App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.dashboard');

});

Route::middleware(['auth','role:docente'])->group(function () {
     Route::get('/docente', [\App\Http\Controllers\Docente\HomeController::class, 'index'])->name('docente.dashboard');
    // aquí irán rutas exclusivas del docente
});

Route::middleware(['web','auth','role:coordinador'])
    ->get('/coordinador', [\App\Http\Controllers\Coordinador\HomeController::class, 'index'])
    ->name('coordinador.dashboard');


// Todo lo de cuenta disponible para cualquier usuario autenticado
Route::middleware('auth')->group(function () {
    Route::put('/account/profile',  [AccountController::class, 'updateProfile'])->name('account.update.profile');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.update.password');
    Route::put('/account/phone',    [AccountController::class, 'updatePhone'])->name('account.update.phone');
});


use App\Http\Controllers\Coordinador\AulaController;

Route::prefix('coordinador')->middleware(['auth','role:coordinador'])->group(function () {
    Route::resource('aulas', AulaController::class)->only(['index','create','store','edit','update']);
    Route::put('aulas/{aula}/activar',    [AulaController::class, 'activar'])->name('aulas.activar');
    Route::put('aulas/{aula}/desactivar', [AulaController::class, 'desactivar'])->name('aulas.desactivar');
});
