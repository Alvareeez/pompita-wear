<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudPlantilla extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_plantilla';

    protected $fillable = [
        'empresa_id',
        'plan_id',
        'slug',
        'nombre',
        'foto',
        'enlace',
        'color_primario',
        'color_secundario',
        'color_terciario',
        'estado',
        'solicitada_en',
    ];

    protected $casts = [
        'solicitada_en' => 'datetime',
        'procesada_en'  => 'datetime',
    ];

    /**
     * La empresa que realizó la solicitud.
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

    /**
     * El plan asociado a la solicitud.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id');
    }
}
