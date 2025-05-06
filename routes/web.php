<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Admin\RopaController;
use App\Http\Controllers\PrendaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OutfitController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ShowOutfitsController;
use App\Http\Controllers\DetailsOutfitsController;
use App\Http\Controllers\SeguimientoController;


use App\Http\Controllers\Admin\EstiloController;
use App\Http\Controllers\Admin\EtiquetaController;
use App\Http\Controllers\OutfitController2;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DonationController;



Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');


// RUTAS DE INICIO --------------------------------------------------------------------------------------------
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
    Route::get('/usuarios/filtrar', [UsuarioController::class, 'filtrar'])->name('admin.usuarios.filtrar');

    Route::get('/ropa', [RopaController::class, 'index'])->name('admin.ropa.index');
    Route::get('/ropa/create', [RopaController::class, 'create'])->name('admin.ropa.create');
    Route::post('/ropa', [RopaController::class, 'store'])->name('admin.ropa.store');
    Route::get('/ropa/{id}/edit', [RopaController::class, 'edit'])->name('admin.ropa.edit');
    Route::put('/ropa/{id}', [RopaController::class, 'update'])->name('admin.ropa.update');
    Route::delete('/ropa/{id}', [RopaController::class, 'destroy'])->name('admin.ropa.destroy');
    Route::post('/ropa/pdf', [RopaController::class, 'descargarPDF'])->name('admin.ropa.pdf');


    Route::get('/estilos', [EstiloController::class, 'index'])->name('admin.estilos.index');
    Route::get('/estilos/create', [EstiloController::class, 'create'])->name('admin.estilos.create');
    Route::post('/estilos', [EstiloController::class, 'store'])->name('admin.estilos.store');
    Route::get('/estilos/{id}/edit', [EstiloController::class, 'edit'])->name('admin.estilos.edit');
    Route::put('/estilos/{id}', [EstiloController::class, 'update'])->name('admin.estilos.update');
    Route::delete('/estilos/{id}', [EstiloController::class, 'destroy'])->name('admin.estilos.destroy');
    Route::get('/admin/estilos/buscar', [EstiloController::class, 'buscar'])->name('admin.estilos.buscar');

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

// Ruta AJAX para filtrar por estilo SIN AUTH
Route::get('/prendas/estilo/{id}/filtrar', [PrendaController::class, 'filtrarPorEstilo'])->name('prendas.filtrarPorEstilo');

Route::middleware(['auth'])->group(
    function () {

        Route::get('/prendas', [PrendaController::class, 'index'])->name('prendas.index');
        Route::get('/prendas/{id}', [PrendaController::class, 'show'])->name('prendas.show');
        Route::post('/prendas/{id}/comentarios', [PrendaController::class, 'storeComment'])->name('prendas.storeComment');
        Route::post('/comentarios/{id}/like', [PrendaController::class, 'toggleCommentLike'])->name('comentarios.toggleLike');
        Route::get('/prendas/{prenda}/favorito', [PrendaController::class, 'toggleFavorite'])->name('prendas.toggleFavorite');
        Route::post('/prendas/{prenda}/like', [PrendaController::class, 'toggleLike'])->name('prendas.like');
        Route::post('/prendas/{id}/valoraciones', [PrendaController::class, 'storeValoracion'])->name('prendas.storeValoracion');
        Route::get('/prendas/estilo/{id}', [PrendaController::class, 'porEstilo'])->name('prendas.porEstilo');

        Route::get('/outfit', [OutfitController::class, 'index'])->name('outfit.index');
        Route::get('/outfit/{id}', [DetailsOutfitsController::class, 'show'])->name('outfit.show');
        Route::post('/outfit/store', [OutfitController::class, 'store'])->name('outfit.store');
        Route::get('/outfits', [ShowOutfitsController::class, 'index'])->name('outfit.outfits');

        Route::get('/perfil', [PerfilController::class, 'show'])->middleware('auth');
        Route::put('/perfil/update', [PerfilController::class, 'update'])->name('perfil.update');
        Route::post('/perfil/eliminar-foto', [PerfilController::class, 'deleteProfilePicture'])
            ->name('perfil.delete-picture')
            ->middleware('auth');
        Route::middleware('auth')->group(function () {
            Route::post('/seguimiento/enviar/{idSeguido}', [SeguimientoController::class, 'enviarSolicitud'])->name('seguimiento.enviar');
            Route::post('/seguimiento/aceptar/{idSeguimiento}', [SeguimientoController::class, 'aceptarSolicitud'])->name('seguimiento.aceptar');
            Route::post('/seguimiento/rechazar/{idSeguimiento}', [SeguimientoController::class, 'rechazarSolicitud'])->name('seguimiento.rechazar');
            Route::get('/seguidores', [SeguimientoController::class, 'listarSeguidores'])->name('seguidores.listar');
            Route::get('/seguidos', [SeguimientoController::class, 'listarSeguidos'])->name('seguidos.listar');
        });
    }
);



Route::get('/calendario', [OutfitController2::class, 'calendario'])->name('calendario');
Route::get('/outfits/create-from-calendar', [OutfitController2::class, 'createFromCalendar'])->name('outfits.createFromCalendar');
Route::post('/outfits/store-from-calendar', [OutfitController2::class, 'storeFromCalendar'])->name('outfits.storeFromCalendar');
Route::get('/outfits/replace', [OutfitController2::class, 'replaceOutfit'])->name('outfits.replace');
Route::post('/outfits/delete', [OutfitController2::class, 'deleteOutfit'])->name('outfits.delete');
Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::post('/donations/process', [DonationController::class, 'process'])->name('donations.process');
Route::get('/donations/checkout', [DonationController::class, 'checkout'])->name('donations.checkout');
Route::get('/donations/success', [DonationController::class, 'success'])->name('donations.success');
Route::get('/donations/cancel', [DonationController::class, 'cancel'])->name('donations.cancel');