<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudDestacado extends Model
{
    protected $table = 'solicitudes_destacado';

    protected $fillable = [
        'empresa_id',
        'prenda_id',
        'plan_id',
        'estado',
        'solicitada_en',
        'aprobada_en',
        'expira_en',
    ];

    public function empresa()
    {
        return $this->belongsTo(\App\Models\Empresa::class, 'empresa_id');
    }

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'prenda_id', 'id_prenda');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
