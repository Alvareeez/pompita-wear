<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrendaVista extends Model
{
    use HasFactory;

    protected $table = 'prenda_vistas';

    protected $fillable = [
        'prenda_id',
        'id_usuario',
    ];
}
