<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversacion extends Model
{
    protected $table = 'conversaciones';

    // Permitimos asignar user1_id y user2_id
    protected $fillable = ['user1_id', 'user2_id'];

    /**
     * Usuario que ocupa la posición 1
     */
    public function user1()
    {
        return $this->belongsTo(Usuario::class, 'user1_id', 'id_usuario');
    }

    /**
     * Usuario que ocupa la posición 2
     */
    public function user2()
    {
        return $this->belongsTo(Usuario::class, 'user2_id', 'id_usuario');
    }

    /**
     * Mensajes de esta conversación
     */
    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'conversacion_id');
    }
}
