<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

  public static function rules($id = null)
  {
    return [
      'identidad' => 'required|unique:proveedors,identidad,' . $id,
      'nombre' => 'required',
      'telefono' => 'required|unique:proveedors,telefono,' . $id,
      'correo' => 'required|email|unique:proveedors,correo,' . $id,
      'direccion' => 'required'
    ];
  }
  
  protected $fillable = ['identidad', 'nombre', 'telefono', 'correo', 'direccion'];
}