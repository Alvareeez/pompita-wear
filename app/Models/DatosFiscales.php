<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosFiscales extends Model
{
    protected $fillable = [
        'razon_social',
        'nif',
        'direccion',
        'cp',
        'ciudad',
        'provincia',
        'pais',
    ];

    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'datos_fiscales_id');
    }
}
