<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrenda extends Model
{
    use HasFactory;

    protected $table = 'tipo_prendas';
    protected $primaryKey = 'id_tipoPrenda';
    public $timestamps = true;

    protected $fillable = [
        'tipo'
    ];

    public function prendas()
    {
        return $this->hasMany(Prenda::class, 'id_tipoPrenda');
    }
}
