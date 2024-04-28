<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
  use HasFactory;
  static $rules = [
    'monto_inicial' => 'required'
  ];
  protected $fillable = ['monto_inicial', 'fecha_apertura', 'fecha_cierre', 'compras', 'gastos', 'ventas', 'estado', 'id_usuario'];

  public function gastos()
  {
    return $this->hasMany(Gasto::class, 'id_caja');
  }
}
