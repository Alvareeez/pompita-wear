<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prenda extends Model
{
    use HasFactory;

    protected $table = 'prendas';
    protected $primaryKey = 'id_prenda';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'id_tipoPrenda',
        'descripcion',
        'img_frontal',
        'img_trasera',
        'destacada',         
        'destacado_hasta',
    ];

    public function tipoPrenda()
    {
        return $this->belongsTo(TipoPrenda::class, 'id_tipoPrenda');
    }

    public function outfits()
    {
        return $this->belongsToMany(Outfit::class, 'outfit_prendas', 'id_prenda', 'id_outfit');
    }

    public function colores()
    {
        return $this->belongsToMany(Color::class, 'prenda_colores', 'id_prenda', 'id_color');
    }

    public function estilos()
    {
        return $this->belongsToMany(Estilo::class, 'prenda_estilos', 'id_prenda', 'id_estilo');
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'prenda_etiquetas', 'id_prenda', 'id_etiqueta');
    }

    public function favoritos()
{
    return $this->belongsToMany(Usuario::class, 'favoritos_prendas', 'id_prenda', 'id_usuario')
                ->withTimestamps()
                ->using(FavoritoPrenda::class);
}
    public function isFavoritedByUser($userId)
    {
        return $this->favoritos()
                   ->where('favoritos_prendas.id_usuario', $userId)
                   ->exists();
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioPrenda::class, 'id_prenda')->with(['usuario', 'likes'])
        ->orderBy('created_at', 'desc');
    }

    public function valoraciones()
    {
    return $this->hasMany(ValoracionPrenda::class, 'id_prenda')
               ->with('usuario')
               ->orderBy('created_at', 'desc');
    }
    
    public function promedioValoraciones()
    {
    return $this->valoraciones()->avg('puntuacion');
    }
    public function likes()
    {
        return $this->belongsToMany(Usuario::class, 'likes_prendas', 'id_prenda', 'id_usuario')
               ->withPivot('created_at', 'updated_at');
    }

        public function isLikedByUser($userId)
     {
        return $this->likes()->where('likes_prendas.id_usuario', $userId)->exists();
        }

    // Relación con el modelo TipoPrenda
    public function tipo()
    {
        return $this->belongsTo(TipoPrenda::class, 'id_tipoPrenda', 'id_tipoPrenda');
    }
    // Funciones recuperar likes
    public function getLikesCountAttribute()
{
    return $this->likes()->count();
}

    // Scope para prendas destacadas activas
    public function scopeDestacadas($query)
    {
        return $query->where('destacada', true)
                     ->where(function($q) {
                         $q->whereNull('destacado_hasta')
                           ->orWhere('destacado_hasta', '>=', now()->toDateString());
                     });
    }
    
}
