<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrendaColor extends Model
{
    use HasFactory;

    protected $table = 'prenda_colores';
    protected $primaryKey = ['id_prenda', 'id_color'];
    public $incrementing = false;
    public $timestamps = true;

    protected $fillable = [
        'id_prenda',
        'id_color'
    ];

    public function prenda()
    {
        return $this->belongsTo(Prenda::class, 'id_prenda');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'id_color');
    }
}
