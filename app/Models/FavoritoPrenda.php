<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritoPrenda extends Model
{
    use HasFactory;

    protected $table = 'favoritos_prendas';
    protected $primaryKey = ['id_prenda', 'id_usuario'];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_prenda',
        'id_usuario'
    ];

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'id_prenda');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
    public function favoritos()
{
    return $this->belongsToMany(Usuario::class, 'favoritos_prendas', 'id_prenda', 'id_usuario')
                ->withTimestamps()
                ->using(FavoritoPrenda::class);
}
}
