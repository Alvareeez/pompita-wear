<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\RopaController;
use App\Http\Controllers\PrendaController;
use App\Http\Controllers\HomeController;


use App\Http\Controllers\Admin\EstiloController;
use App\Http\Controllers\Admin\EtiquetaController;



Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');


// RUTAS DE INICIO ---------------------------------------------------------------------------
Route::view('/login', 'login.login')->name('login')->middleware('guest');
Route::view('/registro', 'registro.registro')->middleware('guest');

Route::post('/registro', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// RUTAS DE SEGURIZADAS COMO ADMIN ---------------------------------------------------------------------------
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

    Route::get('/estilos', [EstiloController::class, 'index'])->name('admin.estilos.index');
    Route::get('/estilos/create', [EstiloController::class, 'create'])->name('admin.estilos.create');
    Route::post('/estilos', [EstiloController::class, 'store'])->name('admin.estilos.store');
    Route::get('/estilos/{id}/edit', [EstiloController::class, 'edit'])->name('admin.estilos.edit');
    Route::put('/estilos/{id}', [EstiloController::class, 'update'])->name('admin.estilos.update');
    Route::delete('/estilos/{id}', [EstiloController::class, 'destroy'])->name('admin.estilos.destroy');

    Route::get('/etiquetas', [EtiquetaController::class, 'index'])->name('admin.etiquetas.index');
    Route::get('/etiquetas/create', [EtiquetaController::class, 'create'])->name('admin.etiquetas.create');
    Route::post('/etiquetas', [EtiquetaController::class, 'store'])->name('admin.etiquetas.store');
    Route::get('/etiquetas/{id}/edit', [EtiquetaController::class, 'edit'])->name('admin.etiquetas.edit');
    Route::put('/etiquetas/{id}', [EtiquetaController::class, 'update'])->name('admin.etiquetas.update');
    Route::delete('/etiquetas/{id}', [EtiquetaController::class, 'destroy'])->name('admin.etiquetas.destroy');
});
Route::get('/outfit', function () {
    return view('outfit');
})->middleware('auth');
// RUTAS DE SEGURIZADAS CLIENTES ---------------------------------------------------------------------------

Route::middleware(['auth'])->group(
    function () {

        Route::get('/prendas', [PrendaController::class, 'index'])->name('prendas.index');
        Route::get('/prendas/{id}', [PrendaController::class, 'show'])->name('prendas.show');
        Route::post('/prendas/{id}/comentarios', [PrendaController::class, 'storeComment'])->name('prendas.storeComment');
        Route::post('/comentarios/{id}/like', [PrendaController::class, 'toggleCommentLike'])    ->name('comentarios.toggleLike');
        Route::post('/prendas/{prenda}/like', [PrendaController::class, 'toggleLike'])->name('prendas.like');
        Route::post('/prendas/{id}/valoraciones', [PrendaController::class, 'storeValoracion'])->name('prendas.storeValoracion');
        Route::get('/prendas/estilo/{id}', [PrendaController::class, 'porEstilo'])->name('prendas.porEstilo');
    }
);

Route::get('/perfil', function () {
    return view('perfil');
})->middleware('auth');
