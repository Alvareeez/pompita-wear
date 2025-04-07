<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ValoracionOutfit extends Model
{
    use HasFactory;

    protected $table = 'valoraciones_outfits';
    protected $primaryKey = 'id_valoracion';
    public $timestamps = true;

    protected $fillable = [
        'id_outfit',
        'id_usuario',
        'puntuacion'
    ];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class, 'id_outfit');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
