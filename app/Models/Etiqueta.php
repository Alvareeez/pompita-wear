<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etiqueta extends Model
{
    use HasFactory;

    protected $table = 'etiquetas';
    protected $primaryKey = 'id_etiqueta';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    public function prendas()
    {
        return $this->belongsToMany(Prenda::class, 'prenda_etiquetas', 'id_etiqueta', 'id_prenda');
    }
}
