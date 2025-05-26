<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DatosFiscales extends Model
{
    public function empresas()
    {
        return $this->hasMany(Empresa::class, 'datos_fiscales_id');
    }
}
