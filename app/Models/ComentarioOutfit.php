<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComentarioOutfit extends Model
{
    use HasFactory;

    protected $table = 'comentarios_outfits';
    protected $primaryKey = 'id_comentario';
    public $timestamps = true;

    protected $fillable = [
        'id_outfit',
        'id_usuario',
        'comentario'
    ];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class, 'id_outfit');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function likes()
    {
        return $this->hasMany(LikeComentarioOutfit::class, 'id_comentario');
    }
}
