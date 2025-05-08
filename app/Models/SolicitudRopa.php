<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitudRopa extends Model
{
    use HasFactory;

    protected $table = 'solicitudes_ropa';

    protected $fillable = [
        'id_usuario',
        'nombre',
        'descripcion',
        'id_tipoPrenda',
        'precio',
        'img_frontal',
        'img_trasera',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    public function tipoPrenda()
    {
        return $this->belongsTo(TipoPrenda::class, 'id_tipoPrenda', 'id_tipoPrenda'); // Ajustar la clave foránea
    }

    public function etiquetas()
    {
        return $this->belongsToMany(Etiqueta::class, 'solicitud_etiqueta', 'id_solicitud', 'id_etiqueta');
    }

    public function colores()
    {
        return $this->belongsToMany(Color::class, 'solicitud_color', 'id_solicitud', 'id_color');
    }

    public function estilos()
    {
        return $this->belongsToMany(Estilo::class, 'solicitud_estilo', 'id_solicitud', 'id_estilo');
    }
}
