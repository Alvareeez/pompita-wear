<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeComentarioPrenda extends Model
{
    use HasFactory;

    protected $table = 'likes_comentarios_prendas';
    protected $primaryKey = 'id_like';
    public $timestamps = true;

    protected $fillable = [
        'id_comentario',
        'id_usuario'
    ];

    public function comentario()
    {
        return $this->belongsTo(ComentarioPrenda::class, 'id_comentario');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
