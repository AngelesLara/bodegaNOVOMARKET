<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Producto
 *
 * @property $id
 * @property $codigo
 * @property $producto
 * @property $precio_compra
 * @property $precio_venta
 * @property $foto
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Producto extends Model
{

  public static function rules($id = null)
  {
    return [
      'codigo' => 'required|unique:productos,codigo,' . $id,
      'producto' => 'required',
      'precio_compra' => 'required',
      'precio_venta' => 'required',
      'stock' => 'required',
      'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'id_categoria' => 'required|exists:categorias,id',
    ];
  }

  protected $perPage = 20;

  /**
   * Attributes that should be mass-assignable.
   *
   * @var array
   */
  protected $fillable = ['codigo', 'producto', 'precio_compra', 'precio_venta', 'stock', 'foto', 'id_categoria'];

  public function categoria()
  {
    return $this->belongsTo(Categoria::class, 'id_categoria');
  }
}
