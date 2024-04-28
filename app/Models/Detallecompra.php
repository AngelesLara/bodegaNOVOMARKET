<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetalleCompra extends Model
{
  protected $table = 'detallecompra';
  protected $fillable = ['precio', 'cantidad', 'id_producto', 'id_compra'];

  public function compra()
  {
    return $this->belongsTo(Compra::class, 'id_compra', 'id');
  }
}
