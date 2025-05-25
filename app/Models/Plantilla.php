<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    use HasFactory;

    protected $table = 'plantillas';

    protected $fillable = [
        'empresa_id',
        'programador_id',
        'slug',
        'nombre',
        'foto',
        'enlace',
        'color_primario',
        'color_secundario',
        'color_terciario',
    ];

    /**
     * La empresa que pidió esta plantilla.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    /**
     * El programador que la aprobó.
     */
    public function programador()
    {
        // Usuario modelo se llama Usuario con PK id_usuario
        return $this->belongsTo(Usuario::class, 'programador_id', 'id_usuario');
    }
}
