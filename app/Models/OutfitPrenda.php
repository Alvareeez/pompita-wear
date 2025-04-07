<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutfitPrenda extends Model
{
    use HasFactory;

    protected $table = 'outfit_prendas';
    protected $primaryKey = 'id_outfit_prenda';
    public $timestamps = true;

    protected $fillable = [
        'id_outfit',
        'id_prenda'
    ];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class, 'id_outfit');
    }

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'id_prenda');
    }
}
