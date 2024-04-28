<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

  public static function rules($id = null)
  {
    return [
      'nombre' => 'required',
      'telefono' => 'required|unique:clientes,nombre,' . $id,
      'direccion' => 'required',
      'credito' => 'required',
      'correo' => 'nullable|email',
    ];
  }

  protected $fillable = ['nombre', 'telefono', 'correo', 'credito', 'direccion'];

  public function creditos()
  {
    return $this->hasMany(Creditoventa::class, 'id_cliente');
  }
}
