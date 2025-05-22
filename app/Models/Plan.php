<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'planes';

    protected $fillable = [
        'nombre',
        'precio',
        'duracion_dias',
        'descripcion',
    ];

    public function solicitudesDestacado()
    {
        return $this->hasMany(SolicitudDestacado::class, 'plan_id');
    }
}
