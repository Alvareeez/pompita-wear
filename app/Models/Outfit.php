<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outfit extends Model
{
    use HasFactory;

    protected $table = 'outfits';
    protected $primaryKey = 'id_outfit';
    public $timestamps = true;

    protected $fillable = [
        'id_usuario',
        'nombre',
    ];

    // Creador del outfit
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    // Prendas asociadas
    public function prendas()
    {
        return $this->belongsToMany(
            Prenda::class,
            'outfit_prendas',
            'id_outfit',
            'id_prenda'
        )->withTimestamps();
    }

    // Usuarios que han marcado como favoritos
    public function favoritos()
    {
        return $this->belongsToMany(
            Usuario::class,
            'favoritos_outfits',
            'id_outfit',
            'id_usuario'
        )->withTimestamps();
    }

    // Comprueba si un usuario ha marcado favorito
    public function isFavoritedByUser(int $userId): bool
    {
        return $this->favoritos()
                    ->wherePivot('id_usuario', $userId)
                    ->exists();
    }

    // Likes del outfit
    public function likes()
    {
        return $this->belongsToMany(
            Usuario::class,
            'likes_outfits',
            'id_outfit',
            'id_usuario'
        )->withTimestamps();
    }

    public function isLikedByUser(int $userId): bool
    {
        return $this->likes()
                    ->wherePivot('id_usuario', $userId)
                    ->exists();
    }

    // Valoraciones
    public function valoraciones()
    {
        return $this->hasMany(ValoracionOutfit::class, 'id_outfit', 'id_outfit');
    }

    // Comentarios
    public function comentarios()
    {
        return $this->hasMany(ComentarioOutfit::class, 'id_outfit', 'id_outfit');
    }

    // Promedio de puntuación
    public function puntuacionPromedio(): float
    {
        return $this->valoraciones()->avg('puntuacion') ?: 0;
    }

    // Valoración concreta de un usuario
    public function valoracionUsuario(int $userId)
    {
        return $this->valoraciones()
                    ->where('id_usuario', $userId)
                    ->first();
    }
}
