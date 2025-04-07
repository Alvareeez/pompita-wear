<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estilo extends Model
{
    use HasFactory;

    protected $table = 'estilos';
    protected $primaryKey = 'id_estilo';
    public $timestamps = true;

    protected $fillable = [
        'nombre'
    ];

    public function prendas()
    {
        return $this->belongsToMany(Prenda::class, 'prenda_estilos', 'id_estilo', 'id_prenda');
    }
}
