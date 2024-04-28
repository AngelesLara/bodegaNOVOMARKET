<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Compra;
use App\Models\Cotizacion;
use App\Models\Creditoventa;
use App\Models\Forma;
use App\Models\Gasto;
use App\Models\Proveedor;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DatatableController extends Controller
{
    public function products()
    {
        $products = Producto::select(
            'productos.id',
            'productos.codigo',
            'productos.producto',
            'productos.precio_compra',
            'productos.precio_venta',
            'productos.stock',
            'productos.foto',
            'categorias.nombre as categoria'
        )
            ->leftJoin('categorias', 'productos.id_categoria', '=', 'categorias.id') // Hacer un left join con la tabla categorias
            ->orderBy('productos.id', 'desc')
            ->get();

        return DataTables::of($products)->toJson();
    }

    public function clients()
    {
        $clients = Cliente::select('id', 'nombre', 'telefono', 'correo', 'credito', 'direccion')
            ->orderBy('id', 'desc')->get();
        return DataTables::of($clients)->toJson();
    }

    public function proveedors()
    {
        $proveedors = Proveedor::select('id', 'identidad', 'nombre', 'telefono', 'correo', 'direccion')
            ->orderBy('id', 'desc')->get();
        return DataTables::of($proveedors)->toJson();
    }

    public function users()
    {
        $users = User::select('id', 'name', 'email', 'created_at')
            ->orderBy('id', 'desc')->get();
        return DataTables::of($users)->toJson();
    }

    public function categories()
    {
        $categories = Categoria::select('id', 'nombre')
            ->orderBy('id', 'desc')->get();
        return DataTables::of($categories)->toJson();
    }

    public function formas()
    {
        $formas = Forma::select('id', 'nombre')
            ->orderBy('id', 'desc')->get();
        return DataTables::of($formas)->toJson();
    }

    public function gastos()
    {
        $id_user = Auth::id();
        $gastos = Gasto::with(['usuario'])
            ->where('id_usuario', $id_user)->get();
        $data = [];

        foreach ($gastos as $gasto) {
            $foto = ($gasto->foto) ? asset('storage/' . $gasto->foto) : null;
            $data[] = [
                'id' => $gasto->id,
                'monto' => number_format($gasto->monto, 2),
                'descripcion' => $gasto->descripcion,
                'foto' => $foto,
                'usuario' => $gasto->usuario->name,
                'created_at' => $gasto->created_at->format('Y-m-d H:i:s'),
            ];
        }
        return DataTables::of($data)->toJson();
    }

    public function sales()
    {
        $id_user = Auth::id();
        $sales = Venta::with(['cliente', 'formapago'])
            ->whereIn('ventas.estado', [1, 2])
            ->where('id_usuario', $id_user)->get();
        $data = [];

        foreach ($sales as $venta) {
            $data[] = [
                'id' => $venta->id,
                'total' => number_format($venta->total, 2),
                'cliente' => $venta->cliente->nombre,
                'metodo' => $venta->metodo,
                'formapago' => $venta->formapago->nombre,
                'created_at' => $venta->created_at->format('Y-m-d H:i:s'),
            ];
        }
        return DataTables::of($data)->toJson();
    }

    public function creditoventas()
    {
        $id_user = Auth::id();

        $creditos = Creditoventa::with('cliente', 'abonos')
            ->where('id_usuario', $id_user)
            ->get();

        $data = [];

        foreach ($creditos as $credito) {
            $abonado = $credito->abonos->sum('monto');
            $restante = $credito->monto - $abonado;

            $data[] = [
                'id' => $credito->id,
                'total' => number_format($credito->monto, 2),
                'cliente' => $credito->cliente->nombre,
                'abonado' => number_format($abonado, 2, '.', ''),
                'restante' => number_format($restante, 2, '.', ''),
                'fecha' => $credito->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return DataTables::of($data)->toJson();
    }


    public function compras()
    {
        $id_user = Auth::id();
        $compras = Compra::join('proveedors', 'compras.id_proveedor', '=', 'proveedors.id')
            ->select('compras.*', 'proveedors.nombre')
            ->orderBy('compras.id', 'desc')
            ->whereIn('compras.estado', [1, 2])  // Cambio aquí
            ->where('compras.id_usuario', $id_user)
            ->get();
        return DataTables::of($compras)->toJson();
    }

    public function cotizaciones()
    {
        $id_user = Auth::id();
        $cotizaciones = Cotizacion::join('clientes', 'cotizaciones.id_cliente', '=', 'clientes.id')
            ->select('cotizaciones.*', 'clientes.nombre')
            ->orderBy('cotizaciones.id', 'desc')->where('cotizaciones.id_usuario', $id_user)->get();
        return DataTables::of($cotizaciones)->toJson();
    }

    public function cajas()
    {
        $id_user = Auth::id();
        $cajas = Caja::select('id', 'monto_inicial', 'fecha_apertura', 'fecha_cierre', 'estado', 'compras', 'gastos', 'ventas')
            ->orderBy('id', 'desc')->where('id_usuario', $id_user)->get();
        return DataTables::of($cajas)->toJson();
    }
}
