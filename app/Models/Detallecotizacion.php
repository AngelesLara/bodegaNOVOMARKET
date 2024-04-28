<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detallecotizacion extends Model
{
    use HasFactory;
    protected $table = 'detallecotizacion';
    protected $fillable = ['precio', 'cantidad', 'id_producto', 'id_cotizacion'];

    public function cotizacion()
    {
        return $this->belongsTo(Cotizacion::class, 'id_cotizacion', 'id');
    }
}
