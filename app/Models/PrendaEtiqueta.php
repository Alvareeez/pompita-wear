<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrendaEtiqueta extends Model
{
    use HasFactory;

    protected $table = 'prenda_etiquetas';
    protected $primaryKey = 'id_prenda_etiquetas';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_prenda',
        'id_etiqueta',
    ];

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'id_prenda');
    }

    public function etiqueta()
    {
        return $this->belongsTo(Etiqueta::class, 'id_etiqueta');
    }
}
