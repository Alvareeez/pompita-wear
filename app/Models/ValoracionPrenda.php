<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoracionPrenda extends Model
{
    use HasFactory;

    protected $table = 'valoraciones_prendas';
    protected $primaryKey = 'id_valoracion';
    public $timestamps = true;

    protected $fillable = [
        'id_prenda',
        'id_usuario',
        'puntuacion'
    ];

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'id_prenda');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
