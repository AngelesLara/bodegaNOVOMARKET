<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonoventa extends Model
{
  protected $fillable = ['monto', 'id_caja', 'id_forma', 'id_usuario', 'id_credito'];

  public function creditoventa()
  {
    return $this->belongsTo(Creditoventa::class, 'id_credito');
  }

  public function formapago()
  {
    return $this->belongsTo(Forma::class, 'id_forma');
  }

  public function usuario()
  {
    return $this->belongsTo(User::class, 'id_usuario');
  }
}
