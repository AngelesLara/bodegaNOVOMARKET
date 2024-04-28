<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
  protected $fillable = ['total', 'pago_con', 'metodo', 'estado', 'id_cliente', 'id_caja', 'id_forma', 'id_usuario'];

  public function detalleventa()
  {
    return $this->hasMany(Detalleventa::class, 'id_venta', 'id');
  }

  public function cliente()
  {
    return $this->belongsTo(Cliente::class, 'id_cliente');
  }

  public function formapago()
  {
    return $this->belongsTo(Forma::class, 'id_forma');
  }

  public function creditos()
    {
        return $this->hasMany(Creditoventa::class, 'id_venta');
    }
}
