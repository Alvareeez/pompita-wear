<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritoPrenda extends Model
{
    use HasFactory;

    protected $table = 'favoritos_prendas';
    protected $primaryKey = 'id_favoritos_prendas';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_prenda',
        'id_usuario',
    ];

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'id_prenda');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
