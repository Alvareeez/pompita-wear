<?php
// filepath: c:\wamp64\www\pompita-wear\app\Models\Usuario.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'id_rol',
        'foto_perfil',
        'provider',
        'provider_id',
        'estado',
        'is_private',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_private' => 'boolean',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol', 'id_rol');
    }

    public function outfits()
    {
        return $this->hasMany(Outfit::class, 'id_usuario');
    }

    public function favoritosOutfits(): BelongsToMany
    {
        return $this->belongsToMany(
            Outfit::class,
            'favoritos_outfits',
            'id_usuario',
            'id_outfit'
        );
    }

    public function favoritosPrendas(): BelongsToMany
    {
        return $this->belongsToMany(
            Prenda::class,
            'favoritos_prendas',
            'id_usuario',
            'id_prenda'
        );
    }

    public function comentariosOutfits()
    {
        return $this->hasMany(ComentarioOutfit::class, 'id_usuario');
    }

    public function comentariosPrendas()
    {
        return $this->hasMany(ComentarioPrenda::class, 'id_usuario');
    }

    public function valoracionesOutfits()
    {
        return $this->hasMany(ValoracionOutfit::class, 'id_usuario');
    }

    public function valoracionesPrendas()
    {
        return $this->hasMany(ValoracionPrenda::class, 'id_usuario');
    }

    public function likesComentariosOutfits()
    {
        return $this->hasMany(LikeComentarioOutfit::class, 'id_usuario');
    }

    public function likesComentariosPrendas()
    {
        return $this->hasMany(LikeComentarioPrenda::class, 'id_usuario');
    }

    public function likes()
    {
        return $this->belongsToMany(
            Prenda::class,
            'likes_prendas',
            'id_prenda',
            'id_usuario'
        )->withTimestamps();
    }

    public function empresa()
    {
    return $this->hasOne(Empresa::class, 'usuario_id', 'id_usuario');
    }

    // SEGUIMIENTO

    public function solicitudesEnviadas()
    {
        return $this->hasMany(Solicitud::class, 'id_emisor');
    }

    /**
     * Solicitudes que recibí
     */
    public function solicitudesRecibidas()
    {
        return $this->hasMany(Solicitud::class, 'id_receptor');
    }

    /**
     * Usuarios que me siguen (solicitudes aceptadas)
     */
    public function seguidores()
    {
        return $this->belongsToMany(
            Usuario::class,
            'solicitudes',
            'id_receptor',
            'id_emisor'
        )
        ->withPivot('status')
        ->wherePivot('status', 'aceptada')
        ->withTimestamps();
    }

    /**
     * Usuarios a los que sigo (solicitudes aceptadas)
     */
    public function siguiendo()
    {
        return $this->belongsToMany(
            Usuario::class,
            'solicitudes',
            'id_emisor',
            'id_receptor'
        )
        ->withPivot('status')
        ->wherePivot('status', 'aceptada')
        ->withTimestamps();
    }

    public function outfitsFavoritos()
    {
        return $this->belongsToMany(\App\Models\Outfit::class, 'favoritos_outfits', 'id_usuario', 'id_outfit');
    }

}
