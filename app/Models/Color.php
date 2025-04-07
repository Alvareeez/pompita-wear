<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colores';
    protected $primaryKey = 'id_color';
    public $timestamps = true;

    protected $fillable = [
        'nombre'
    ];

    public function prendas()
    {
        return $this->belongsToMany(Prenda::class, 'prenda_colores', 'id_color', 'id_prenda');
    }
}
