<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;
    protected $table = 'cotizaciones';
    protected $fillable = ['total', 'estado', 'id_cliente', 'id_usuario'];

    public function detallecotizacion()
    {
        return $this->hasMany(Detallecotizacion::class, 'id_cotizacion', 'id');
    }
}
