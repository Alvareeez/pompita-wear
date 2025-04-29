<?php
// Seguimiento.php
namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Seguimiento extends Pivot
{
    protected $table = 'seguidores';
    public $incrementing = true; // Para que funcione el id autoincremental
    protected $primaryKey = 'id_seguimiento';

    protected $fillable = [
        'id_seguidor',
        'id_seguido',
        'estado',
    ];

    // Opcional: si necesitas acceder a los modelos relacionados
    public function seguidor()
    {
        return $this->belongsTo(Usuario::class, 'id_seguidor');
    }

    public function seguido()
    {
        return $this->belongsTo(Usuario::class, 'id_seguido');
    }
}
