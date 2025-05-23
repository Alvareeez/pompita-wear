<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    protected $table = 'plantillas';

    protected $fillable = [
        'empresa_id',
        'programador_id',
        'slug',
        'nombre',
        'foto',
        'enlace',
        'colores',
        'estado',
    ];

    protected $casts = [
        'colores' => 'array',
    ];

    /**
     * La empresa que solicitó la plantilla.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    /**
     * El programador asignado.
     */
    public function programador()
    {
        return $this->belongsTo(Usuario::class, 'programador_id', 'id_usuario');
    }
}
