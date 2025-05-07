<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Solicitud extends Model
{
    protected $table = 'solicitudes';
    protected $primaryKey = 'id_solicitud';
    public $timestamps = true;

    protected $fillable = ['solicitante_id','solicitado_id','estado'];

    public function solicitante()
    {
        return $this->belongsTo(Usuario::class,'solicitante_id','id_usuario');
    }

    public function solicitado()
    {
        return $this->belongsTo(Usuario::class,'solicitado_id','id_usuario');
    }
}
