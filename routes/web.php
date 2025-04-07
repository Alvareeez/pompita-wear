<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('cliente.index');
})->middleware('auth');

// RUTAS DE INICIO ---------------------------------------------------------------------------
Route::view('/login', 'login.login')->name('login')->middleware('guest');
Route::view('/registro', 'registro.registro')->middleware('guest');

Route::post('/registro', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');


// RUTAS DE SEGURIZADAS ---------------------------------------------------------------------------

