<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeOutfit extends Model
{
    use HasFactory;

    protected $table = 'likes_outfits';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_usuario',
        'id_outfit',
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
