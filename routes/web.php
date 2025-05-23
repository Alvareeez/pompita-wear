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
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\GestorController;
use App\Http\Controllers\ProgramadorController;




use App\Http\Controllers\Admin\EstiloController;
use App\Http\Controllers\Admin\EtiquetaController;
use App\Http\Controllers\OutfitController2;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\SolicitudRopaController;
use App\Http\Controllers\Admin\ColorController;


// RUTAS PARA LOGIN SOCIAL CON GOOGLE (deben ir antes de cualquier ruta /login o /auth)
Route::get('auth/google/redirect', [SocialController::class, 'redirect'])
    ->name('google.redirect');
Route::get('auth/google/callback',  [SocialController::class, 'callback'])
    ->name('google.callback');

Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');


// RUTAS DE INICIO --------------------------------------------------------------------------------------------
Route::view('/login', 'login.login')->name('login')->middleware('guest');
Route::view('/registro', 'registro.registro')->middleware('guest');

Route::post('/registro', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::post('/reactivar-cuenta', [AuthController::class, 'reactivarCuenta'])->name('reactivar.cuenta');


// RUTAS DE SEGURIZADAS COMO ADMIN ---------------------------------------------------------------------------
Route::prefix('admin')->middleware('auth')->group(function () {

    // RUTAS DE CRUDS

    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('admin.usuarios.index');
    Route::get('/usuarios/create', [UsuarioController::class, 'create'])->name('admin.usuarios.create');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('admin.usuarios.store');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('admin.usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('admin.usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy');
    Route::get('/usuarios/filtrar', [UsuarioController::class, 'filtrar'])->name('admin.usuarios.filtrar');
    Route::post('/usuarios/update-estado', [UsuarioController::class, 'updateEstado'])->name('admin.usuarios.updateEstado');

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

    // Mostrar solicitudes pendientes para el administrador
    Route::get('/solicitudes', [SolicitudRopaController::class, 'index'])->name('admin.solicitudes.index');

    // Actualizar el estado de una solicitud (aceptar o rechazar)
    Route::put('/solicitudes/{solicitud}', [SolicitudRopaController::class, 'update'])->name('admin.solicitudes.update');
    Route::put('/admin/solicitudes/{solicitud}', [SolicitudRopaController::class, 'update'])->name('admin.solicitudes.update');

    Route::get('/colores', [ColorController::class, 'index'])->name('admin.colores.index');
    Route::get('/colores/create', [ColorController::class, 'create'])->name('admin.colores.create');
    Route::post('/colores', [ColorController::class, 'store'])->name('admin.colores.store');
    Route::get('/colores/{id}/edit', [ColorController::class, 'edit'])->name('admin.colores.edit');
    Route::put('/colores/{id}', [ColorController::class, 'update'])->name('admin.colores.update');
    Route::delete('/colores/{id}', [ColorController::class, 'destroy'])->name('admin.colores.destroy');
});

// RUTAS DE SEGURIZADAS CLIENTES ---------------------------------------------------------------------------

Route::middleware(['auth'])->group(
    function () {

        // RUTAS DE PRENDAS
        Route::get('/prendas', [PrendaController::class, 'index'])->name('prendas.index');
        Route::get('/prendas/{id}', [PrendaController::class, 'show'])->name('prendas.show');
        Route::post('/prendas/{id}/comentarios', [PrendaController::class, 'storeComment'])->name('prendas.storeComment');
        Route::post('/comentarios/{id}/like', [PrendaController::class, 'toggleCommentLike'])->name('comentarios.toggleLike');
        Route::get('/prendas/{prenda}/favorito', [PrendaController::class, 'toggleFavorite'])->name('prendas.toggleFavorite');
        Route::post('/prendas/{prenda}/like', [PrendaController::class, 'toggleLike'])->name('prendas.like');
        Route::post('/prendas/{id}/valoraciones', [PrendaController::class, 'storeValoracion'])->name('prendas.storeValoracion');
        Route::get('/prendas/estilo/{id}', [PrendaController::class, 'porEstilo'])->name('prendas.porEstilo');

        // Ruta AJAX para filtrar por estilo
        Route::get('/prendas/estilo/{id}/filtrar', [PrendaController::class, 'filtrarPorEstilo'])->name('prendas.filtrarPorEstilo');

        // RUTAS DE OUTFITS
        Route::get('/outfit', [OutfitController::class, 'index'])->name('outfit.index');
        Route::get('/outfits/filtrar', [ShowOutfitsController::class, 'filtrar'])->name('outfit.filtrar');
        // FILTROS AJAX
        Route::get('/outfit/filter-ajax', [OutfitController::class, 'filterAjax'])->name('outfit.filterAjax');
        Route::get('/outfit/{id}', [DetailsOutfitsController::class, 'show'])->name('outfit.show');
        Route::post('/outfit/store', [OutfitController::class, 'store'])->name('outfit.store');
        Route::get('/outfits', [ShowOutfitsController::class, 'index'])->name('outfit.outfits');

        // DAR LIKES A OUTFIT Y A COMENTARIOS, COMENTARIOS Y VALORACIONES
        Route::get('/outfit/{outfit}/like', [DetailsOutfitsController::class, 'toggleLike'])->name('outfit.like');
        Route::post('/outfits/{id}/comentarios', [DetailsOutfitsController::class, 'storeComment'])->name('outfits.storeComment');
        Route::post('/comentarios-outfits/{id}/like', [DetailsOutfitsController::class, 'toggleCommentLike'])->name('outfits.toggleCommentLike');
        Route::post('/outfits/{id}/valoraciones', [DetailsOutfitsController::class, 'storeValoracion'])->name('outfits.storeValoracion');
        Route::post('/outfits/{id}/favorite', [DetailsOutfitsController::class, 'toggleFavorite'])->name('outfits.toggleFavorite');

        // ELIMINAR OUTFIT
        Route::delete('/outfit/{outfit}', [DetailsOutfitsController::class, 'destroy'])->name('outfit.destroy');

        // CALENDARIO:
        Route::get('/calendario', [OutfitController2::class, 'calendario'])->name('calendario');
        Route::get('/outfits/create-from-calendar', [OutfitController2::class, 'createFromCalendar'])->name('outfits.createFromCalendar');
        Route::post('/outfits/store-from-calendar', [OutfitController2::class, 'storeFromCalendar'])->name('outfits.storeFromCalendar');
        Route::get('/outfits/replace', [OutfitController2::class, 'replaceOutfit'])->name('outfits.replace');
        Route::post('/outfits/delete', [OutfitController2::class, 'deleteOutfit'])->name('outfits.delete');

        // NOTIFICACIONES
        Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
        Route::post('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');


        // RED SOCIAL

        // BUSQUEDA DE USUARIOS POR AJAX:
        Route::get('/users/search', [App\Http\Controllers\PerfilController::class, 'search'])->name('users.search');

        // PERFIL PERSONAL DEL USUARIO
        Route::get('/perfil', [PerfilController::class, 'show'])->name('perfil');

        // ACCIONES DEL PERFIL 
        Route::put('/perfil/update', [PerfilController::class, 'update'])->name('perfil.update');
        Route::put('/perfil/update', [PerfilController::class, 'update'])->name('perfil.update');
        Route::post('/perfil/eliminar-foto', [PerfilController::class, 'deleteProfilePicture'])->name('perfil.delete-picture');
        Route::post('/perfil/delete-profile-picture', [PerfilController::class, 'deleteProfilePicture'])->name('perfil.deleteProfilePicture');

        // ENTRAR A PERFIL DE OTRO USUARIO
        Route::get('/perfil/publico/{id}', [PerfilController::class, 'showPublicProfile'])->name('perfil.publico');

        // MANDAR SOLICITUDES DE SEGUIMIENTO
        Route::post('/solicitudes', [SolicitudController::class, 'store'])->name('solicitudes.store');
        Route::delete('/solicitudes/{solicitud}', [SolicitudController::class, 'destroy'])->name('solicitudes.destroy');
        Route::get('/perfil/{other}/mutual', [SolicitudController::class, 'checkMutual'])->name('perfil.checkMutual');

        // MANEJO DE SOLICITUDES DE SEGUIMIENTO
        Route::post('/solicitudes/aceptar/{id}', [PerfilController::class, 'aceptar'])->name('solicitudes.aceptar');
        Route::post('/solicitudes/rechazar/{id}', [PerfilController::class, 'rechazar'])->name('solicitudes.rechazar');

        // DESDE DENTRO DE PERFIL DEJAR DE SEGUIR O QUITAR SEGUIDOR

        // Quitar a un seguidor
        Route::delete('perfil/follower/{id}', [PerfilController::class, 'removeFollower'])->name('perfil.removeFollower');

        // Dejar de seguir
        Route::delete('/perfil/unfollow/{id}', [PerfilController::class, 'unfollow'])->name('perfil.unfollow');

        // CHAT ENTRE SEGUIDOS UNICAMENTE

        // Bandeja de chats (sin conversación abierta)
        Route::get('/chat', [ChatController::class, 'inbox'])->name('chat.inbox');

        // Entre usuarios
        Route::get('chat/{otroUsuario}', [ChatController::class, 'index'])->name('chat.index');
        Route::get('chat/{otroUsuario}/mensajes', [ChatController::class, 'getMessages'])->name('chat.getMessages');
        Route::post('chat/{otroUsuario}/mensajes', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');

        // RUTAS PARA SOLICITUDES DE ROPA

        // Mostrar formulario para crear una solicitud
        Route::get('/solicitar-ropa', [SolicitudRopaController::class, 'create'])->name('solicitudes.create');

        // Guardar una nueva solicitud
        Route::post('/solicitar-ropa', [SolicitudRopaController::class, 'store'])->name('solicitudes.store');


// RUTAS DE SEGURIZADAS EMPRESAS ---------------------------------------------------------------------------


        // 1) Panel y lista de planes
        Route::get('/empresa', [EmpresaController::class, 'index'])
        ->name('empresas.index');

        // 2) Tras elegir plan, seleccionar prenda
        Route::get('/empresa/planes/{plan}/destacar', 
        [EmpresaController::class, 'selectPrenda'])
        ->name('empresa.destacar');

        // 3) Checkout PayPal
        Route::post('/paypal/checkout', 
        [PaymentController::class, 'createOrder'])
        ->name('paypal.checkout');

        // 4) Callbacks PayPal
        Route::get('/paypal/return',   [PaymentController::class, 'captureOrder'])
        ->name('paypal.return');
        Route::get('/paypal/cancel',   [PaymentController::class, 'cancelOrder'])
        ->name('paypal.cancel');

        Route::get('/empresa/prendas/ajax', [EmpresaController::class,'prendasAjax'])
        ->name('empresa.prendas.ajax');


// RUTAS DE SEGURIZADAS GESTORES ---------------------------------------------------------------------------

    // Panel principal del gestor
    Route::get('/gestor', [GestorController::class, 'index'])
         ->name('gestor.index');

    // Acción para marcar una prenda como destacada
    Route::post('/gestor/highlight/{solicitud}', [GestorController::class, 'highlight'])
         ->name('gestor.highlight');

    // Acciones para aprobar o rechazar una solicitu
    Route::post('/gestor/approve/{solicitud}', [GestorController::class,'approve'])
         ->name('gestor.approve');
    Route::post('/gestor/reject/{solicitud}',  [GestorController::class,'reject'])
         ->name('gestor.reject');


    // CRUD de destacados
    Route::get('/gestor/destacados', [GestorController::class,'manageDestacados'])
        ->name('gestor.destacados');
    Route::post('/gestor/destacados/{prenda}/update', [GestorController::class,'updateDestacado'])
        ->name('gestor.destacados.update');


// RUTAS DE SEGURIZADAS GESTORES ---------------------------------------------------------------------------

    // Panel principal
    Route::get('/programador', [ProgramadorController::class, 'index'])
    ->name('programador.index');

    // Aprobación ó rechazo de plantillas
    Route::post('/plantillas/{plantilla}/aprobar', [ProgramadorController::class, 'aprobar'])
    ->name('programador.plantillas.aprobar');
    Route::post('/plantillas/{plantilla}/rechazar', [ProgramadorController::class, 'rechazar'])
    ->name('programador.plantillas.rechazar');
    }
    
);
