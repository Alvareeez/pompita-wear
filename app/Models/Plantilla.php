<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plantilla extends Model
{
    protected $table = 'plantillas';

    protected $fillable = [
        'empresa_id',
        'programador_id',
        'nombre',
        'config',
        'estado',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    public function programador()
    {
        return $this->belongsTo(Usuario::class, 'programador_id', 'id_usuario');
    }
}
