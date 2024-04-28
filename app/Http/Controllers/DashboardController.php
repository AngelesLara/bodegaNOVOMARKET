<?php

namespace App\Http\Controllers;

use App\Models\Abonoventa;
use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\Compra;
use App\Models\Gasto;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class ClienteController
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $totales = [
            'products' => Producto::count(),
            'clients' => Cliente::count()
        ];

        $userId = Auth::id();

        $comprasTotal = Compra::where('id_usuario', $userId)->whereIn('estado', [1, 2])->sum('total');
        $ventasTotal = Venta::where('id_usuario', $userId)->whereIn('estado', [1, 2])->where('metodo', 'Contado')->sum('total');
        $montosTotal = [
            'compras' => $comprasTotal,
            'ventas' => $ventasTotal,
        ];

        $nombresMeses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre',
        ];

        $ventasPorMeses = Venta::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
            ->whereIn('estado', [1, 2])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $ventas = [];
        foreach ($ventasPorMeses as $venta) {
            $year = $venta->year;
            $month = $nombresMeses[$venta->month];
            $ventas[$year][$month] = $venta->total;
        }

        $comprasPorMeses = Compra::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
            ->whereIn('estado', [1, 2])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $compras = [];
        foreach ($comprasPorMeses as $compra) {
            $year = $compra->year;
            $month = $nombresMeses[$compra->month];
            $compras[$year][$month] = $compra->total;
        }

        $hoy = Carbon::now();
        $inicioSemana = $hoy->startOfWeek()->toDateString();
        $finSemana = $hoy->endOfWeek()->toDateString();

        $diasEnEspanol = [
            'Sunday' => 'Domingo',
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
        ];

        $ventasPorSemana = Venta::select(DB::raw('DAYNAME(created_at) as dia'), DB::raw('SUM(total) as total'))
            ->whereIn('estado', [1, 2])
            ->whereBetween('created_at', ["{$inicioSemana} 00:00:00", "{$finSemana} 23:59:59"])
            ->groupBy('dia')
            ->get();

        // Mapea los resultados y agrega la traducción de los días de la semana
        $ventasPorSemana = $ventasPorSemana->map(function ($venta) use ($diasEnEspanol) {
            $venta->diaEnEspanol = $diasEnEspanol[ucfirst(strtolower($venta->dia))];
            return $venta;
        });

        $comprasPorSemana = Compra::select(DB::raw('DAYNAME(created_at) as dia'), DB::raw('SUM(total) as total'))
            ->whereIn('estado', [1, 2])
            ->whereBetween('created_at', ["{$inicioSemana} 00:00:00", "{$finSemana} 23:59:59"])
            ->groupBy('dia')
            ->get();

        // Mapea los resultados y agrega la traducción de los días de la semana
        $comprasPorSemana = $comprasPorSemana->map(function ($compra) use ($diasEnEspanol) {
            $compra->diaEnEspanol = $diasEnEspanol[ucfirst(strtolower($compra->dia))];
            return $compra;
        });       

        $productos = Producto::where('stock', '<=', 15)->limit(12)->get();

        return view('dashboard', compact('ventas', 'productos', 'compras', 'ventasPorSemana', 'comprasPorSemana', 'totales', 'montosTotal'));
    }
}
