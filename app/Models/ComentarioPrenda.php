<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioPrenda extends Model
{
    use HasFactory;

    protected $table = 'comentarios_prendas';
    protected $primaryKey = 'id_comentario';
    public $timestamps = true;

    protected $fillable = [
        'id_prenda',
        'id_usuario',
        'comentario'
    ];

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'id_prenda');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function likes()
    {
        return $this->hasMany(LikeComentarioPrenda::class, 'id_comentario');
    }
}
