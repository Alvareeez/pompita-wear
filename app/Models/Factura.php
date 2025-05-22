<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';

    protected $fillable = [
        'empresa_id',
        'numero',
        'fecha_emision',
        'fecha_vencimiento',
        'total',
        'estado',
        'detalle',
    ];

    protected $casts = [
        'detalle' => 'array',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }
}
