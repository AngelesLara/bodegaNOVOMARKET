<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    protected $fillable = ['monto', 'descripcion', 'foto', 'id_caja', 'id_usuario'];

    // Relación con la tabla 'cajas'
    public function caja()
    {
        return $this->belongsTo(Caja::class, 'id_caja');
    }

    // Relación con la tabla 'users'
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}
