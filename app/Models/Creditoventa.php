<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creditoventa extends Model
{
  protected $fillable = ['monto', 'id_cliente', 'id_venta', 'id_usuario'];

  public function abonos()
  {
    return $this->hasMany(Abonoventa::class, 'id_credito');
  }

  // Relación con Cliente
  public function cliente()
  {
      return $this->belongsTo(Cliente::class, 'id_cliente');
  }

  public function venta()
  {
    return $this->belongsTo(Venta::class, 'id_venta');
  }
}
