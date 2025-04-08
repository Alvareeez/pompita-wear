<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\RopaController;


Route::get('/', function () {
    return view('cliente.index');
})->middleware('auth');

// RUTAS DE INICIO ---------------------------------------------------------------------------
Route::view('/login', 'login.login')->name('login')->middleware('guest');
Route::view('/registro', 'registro.registro')->middleware('guest');

Route::post('/registro', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// RUTAS DE SEGURIZADAS ---------------------------------------------------------------------------
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');

    Route::get('/ropa', [RopaController::class, 'index'])->name('admin.ropa.index');
    Route::get('/ropa/create', [RopaController::class, 'create'])->name('admin.ropa.create');
    Route::post('/ropa', [RopaController::class, 'store'])->name('admin.ropa.store');
    Route::get('/ropa/{id}/edit', [RopaController::class, 'edit'])->name('admin.ropa.edit');
    Route::put('/ropa/{id}', [RopaController::class, 'update'])->name('admin.ropa.update');
    Route::delete('/ropa/{id}', [RopaController::class, 'destroy'])->name('admin.ropa.destroy');
});