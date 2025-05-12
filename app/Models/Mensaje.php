<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $table = 'mensajes';
    protected $fillable = ['conversacion_id','emisor_id','contenido'];
    public function conversacion()
    {
        return $this->belongsTo(Conversacion::class, 'conversacion_id');
    }
    public function emisor()
    {
        return $this->belongsTo(Usuario::class, 'emisor_id', 'id_usuario');
    }
}
