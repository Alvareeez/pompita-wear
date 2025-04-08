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
        'precio',
        'descripcion',
        'likes',
        'img_frontal',
        'img_trasera'
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
        return $this->belongsToMany(Usuario::class, 'favoritos_prendas', 'id_prenda', 'id_usuario');
    }

    public function comentarios()
    {
        return $this->hasMany(ComentarioPrenda::class, 'id_prenda');
    }

    public function valoraciones()
    {
        return $this->hasMany(ValoracionPrenda::class, 'id_prenda');
    }

    // Relación con el modelo TipoPrenda
    public function tipo()
    {
        return $this->belongsTo(TipoPrenda::class, 'id_tipoPrenda', 'id_tipoPrenda');
    }
}
