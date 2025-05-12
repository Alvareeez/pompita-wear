<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;

    protected $table = 'solicitudes';
    protected $fillable = ['id_emisor', 'id_receptor', 'status'];

    // Relaciones
    public function emisor()
    {
        return $this->belongsTo(Usuario::class, 'id_emisor');
    }

    public function receptor()
    {
        return $this->belongsTo(Usuario::class, 'id_receptor');
    }

    // Scopes para cada estado
    public function scopePendiente($query)
    {
        return $query->where('status', 'pendiente');
    }

    public function scopeAceptada($query)
    {
        return $query->where('status', 'aceptada');
    }

    public function scopeRechazada($query)
    {
        return $query->where('status', 'rechazada');
    }
}
