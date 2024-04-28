<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Forma extends Model
{

  public static function rules($id = null)
  {
    return [
      'nombre' => 'required|unique:formas,nombre,' . $id
    ];
  }

  protected $table = 'formas';

  protected $fillable = ['nombre'];
}
