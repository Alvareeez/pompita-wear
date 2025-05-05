<?php
// filepath: c:\wamp64\www\pompita-wear\app\Models\Usuario.php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'id_rol',
        'foto_perfil',
    ];

    protected $hidden = [
        'password',
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
        return $this->belongsToMany(Outfit::class, 'favoritos_outfits', 'id_usuario', 'id_outfit');
    }

    public function favoritosPrendas(): BelongsToMany
    {
        return $this->belongsToMany(Prenda::class, 'favoritos_prendas', 'id_usuario', 'id_prenda');
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
        return $this->belongsToMany(Usuario::class, 'likes_prendas', 'id_prenda', 'id_usuario')
            ->withTimestamps();
    }
    // Relación: usuarios que siguen a este usuario (seguidores)
    public function seguidores()
    {
        return $this->belongsToMany(Usuario::class, 'seguidores', 'id_seguido', 'id_seguidor')
            ->withPivot('estado')
            ->using(Seguimiento::class);
    }

    // Relación: usuarios que este usuario sigue (seguidos)
    public function seguidos()
    {
        return $this->belongsToMany(Usuario::class, 'seguidores', 'id_seguidor', 'id_seguido')
            ->withPivot('estado')
            ->using(Seguimiento::class);
    }
}
