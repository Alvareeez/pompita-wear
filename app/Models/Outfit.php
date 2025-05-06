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
        'likes'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function prendas()
    {
        return $this->belongsToMany(Prenda::class, 'outfit_prendas', 'id_outfit', 'id_prenda');
    }

    public function favoritos()
    {
        return $this->belongsToMany(Usuario::class, 'favoritos_outfits', 'id_outfit', 'id_usuario');
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioOutfit::class, 'id_outfit');
    }

    public function valoraciones()
    {
        return $this->hasMany(ValoracionOutfit::class, 'id_outfit');
    }
        public function puntuacionPromedio()
    {
        return $this->valoraciones()->avg('puntuacion') ?: 0;
    }

    public function tieneValoracionUsuario($userId)
    {
        return $this->valoraciones()->where('id_usuario', $userId)->exists();
    }

    public function valoracionUsuario($userId)
    {
        return $this->valoraciones()->where('id_usuario', $userId)->first();
    }

    public function likes()
    {
        return $this->hasMany(LikeOutfit::class, 'id_outfit');
    }
}
