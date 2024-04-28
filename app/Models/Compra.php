<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
  protected $fillable = ['total', 'estado', 'id_proveedor', 'id_caja', 'id_usuario'];

  public function detallecompra()
  {
    return $this->hasMany(DetalleCompra::class, 'id_compra', 'id');
  }

  public function proveedor()
  {
    return $this->belongsTo(Proveedor::class, 'id_proveedor');
  }
}
