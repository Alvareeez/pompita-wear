<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';

    protected $fillable = [
        'usuario_id',
        'slug',
        'razon_social',
        'nif',
        'datos_fiscales_id',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    public function plantillas()
    {
        return $this->hasMany(Plantilla::class, 'empresa_id');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'empresa_id');
    }
    public function datosFiscales()
    {
        return $this->belongsTo(\App\Models\DatosFiscales::class, 'datos_fiscales_id');
    }
}
