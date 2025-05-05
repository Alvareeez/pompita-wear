<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutfitFecha extends Model
{
    use HasFactory;

    protected $table = 'outfit_fecha';

    protected $fillable = ['outfit_id', 'fecha'];

    public function outfit()
    {
        return $this->belongsTo(Outfit::class, 'outfit_id');
    }
}
