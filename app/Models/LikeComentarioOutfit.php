<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeComentarioOutfit extends Model
{
    use HasFactory;

    protected $table = 'likes_comentarios_outfits';
    protected $primaryKey = 'id_like';
    public $timestamps = true;

    protected $fillable = [
        'id_comentario',
        'id_usuario'
    ];

    public function comentario()
    {
        return $this->belongsTo(ComentarioOutfit::class, 'id_comentario');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
