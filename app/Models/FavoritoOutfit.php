<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FavoritoOutfit extends Model
{
    use HasFactory;

    protected $table = 'favoritos_outfits';
    protected $primaryKey = 'id_favoritos_outfits';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'id_outfit',
        'id_usuario',
    ];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class, 'id_outfit');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }
}
