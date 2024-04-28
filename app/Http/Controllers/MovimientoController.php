<?php

namespace App\Http\Controllers;

use App\Models\Abonoventa;
use App\Models\Caja;
use App\Models\Compra;
use App\Models\Gasto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimientoController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $existe = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();
        if ($existe) {
            $id_caja = $existe->id;
            $montoInicial = $existe->monto_inicial;
            $compras = Compra::where('id_usuario', $userId)->where('id_caja', $id_caja)->where('estado', 1)->sum('total');
            $gastos = Gasto::where('id_usuario', $userId)->where('id_caja', $id_caja)->sum('monto');
            $ventas = Venta::where('id_usuario', $userId)->where('id_caja', $id_caja)->where('estado', 1)->where('metodo', 'Contado')->sum('total');
            $abonoventa = Abonoventa::where('id_usuario', $userId)->where('id_caja', $id_caja)->sum('monto');
            $saldo = ($montoInicial + $ventas + $abonoventa) - ($compras + $gastos);
            return view('caja.movimiento', compact('montoInicial', 'saldo', 'compras', 'gastos', 'ventas', 'abonoventa'));
        } else {
            // Maneja el caso en el que el usuario no tiene una caja
            return view('caja.movimiento', ['error' => 'El usuario no tiene una caja.']);
        }
       
    }
}
