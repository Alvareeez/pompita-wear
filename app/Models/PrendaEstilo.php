<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrendaEstilo extends Model
{
    use HasFactory;

    protected $table = 'prenda_estilos';
    protected $primaryKey = 'id_prenda_estilos';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_prenda',
        'id_estilo',
    ];

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'id_prenda');
    }

    public function estilo()
    {
        return $this->belongsTo(Estilo::class, 'id_estilo');
    }
}
