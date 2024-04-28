<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Compra;
use App\Models\Gasto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CajaController
 * @package App\Http\Controllers
 */
class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::id();
        $caja = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();
        return view('caja.index', compact('caja'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caja = new Caja();
        return view('caja.create', compact('caja'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Caja::$rules);
        $userId = Auth::id();
        $existe = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();
        if ($existe) {
            return redirect()->route('cajas.index')
                ->with('error', 'La caja ya esta abierto.');
        }
        $caja = Caja::create([
            'monto_inicial' => $request->monto_inicial,
            'fecha_apertura' => date('Y-m-d H:i:s'),
            'id_usuario' => $userId
        ]);

        return redirect()->route('cajas.index')
            ->with('success', 'Caja abierto.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Caja $caja
     * @return \Illuminate\Http\Response
     */
    public function update()
    {
        $userId = Auth::id();
        $caja = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();

        if ($caja) {
            $id_caja = $caja->id;
            $fecha_cierre = date('Y-m-d H:i:s');
            $compras = Compra::where('id_usuario', $userId)->where('id_caja', $id_caja)->where('estado', 1)->sum('total');
            $gastos = Gasto::where('id_usuario', $userId)->where('id_caja', $id_caja)->sum('monto');
            $ventas = Venta::where('id_usuario', $userId)->where('id_caja', $id_caja)->where('estado', 1)->sum('total');

            // Actualizar estado en la tabla de cajas
            $caja->update([
                'estado' => 0,
                'fecha_cierre' => $fecha_cierre,
                'compras' => $compras,
                'gastos' => $gastos,
                'ventas' => $ventas,
            ]);

            // Actualizar estados en la tabla de compras
            Compra::where('id_usuario', $userId)->where('estado', 1)->update(['estado' => 2]);

            // Actualizar estados en la tabla de ventas
            Venta::where('id_usuario', $userId)->where('estado', 1)->update(['estado' => 2]);

            return redirect()->route('cajas.index')
                ->with('success', 'Caja cerrada');
        } else {
            return redirect()->route('cajas.index')
                ->with('error', 'La caja está cerrada');
        }
    }
}
