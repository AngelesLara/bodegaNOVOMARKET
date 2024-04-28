<?php

namespace App\Http\Controllers;

use App\Exports\CompraExport;
use App\Models\Abonoventa;
use App\Models\Caja;
use App\Models\Proveedor;
use App\Models\Compania;
use App\Models\Detallecompra;
use App\Models\Compra;
use App\Models\Gasto;
use App\Models\Producto;
use App\Models\Venta;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class ClienteController
 * @package App\Http\Controllers
 */
class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('compra.index');
    }

    public function store(Request $request)
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

            $totalDecimal = Cart::instance('compras')->subtotal();
            $total = str_replace(',', '', $totalDecimal);
            if ($saldo >= $total) {
                $datosCompra = $request->all();

                $id_proveedor = $datosCompra['id_proveedor'];
                //registrar compra

                if ($total > 0) {
                    $sale = Compra::create([
                        'total' => $total,
                        'id_proveedor' => $id_proveedor,
                        'id_caja' => $id_caja,
                        'id_usuario' => $userId,
                    ]);
                    if ($sale) {
                        foreach (Cart::instance('compras')->content() as $item) {
                            Detallecompra::create([
                                'precio' => $item->price,
                                'cantidad' => $item->qty,
                                'id_producto' => $item->id,
                                'id_compra' => $sale->id
                            ]);
                            // Actualizar el stock del producto
                            $producto = Producto::find($item->id);
                            if ($producto) {
                                // Verificar si hay suficiente stock antes de restar la cantidad
                                $producto->increment('stock', $item->qty);
                            }
                        }
                        Cart::instance('compras')->destroy();
                        return response()->json([
                            'title' => 'COMPRA GENERADA',
                            'icon' => 'success',
                            'ticket' => $sale->id
                        ]);
                    }
                } else {
                    return response()->json([
                        'title' => 'CARRITO VACIO',
                        'icon' => 'warning'
                    ]);
                }
            } else {
                return response()->json([
                    'title' => 'SALDO NO DISPONIBLE',
                    'icon' => 'warning'
                ]);
            }
        } else {
            return response()->json([
                'title' => 'LA CAJA ESTA CERRADO',
                'icon' => 'warning',
            ]);
        }
    }

    public function ticket($id)
    {
        $data['company'] = Compania::first();

        $data['compra'] = Compra::join('proveedors', 'compras.id_proveedor', '=', 'proveedors.id')
            ->select('compras.*', 'proveedors.nombre', 'proveedors.telefono', 'proveedors.direccion')
            ->where('compras.id', $id)
            ->first();

        $data['productos'] = Detallecompra::join('productos', 'detallecompra.id_producto', '=', 'productos.id')
            ->select('detallecompra.*', 'productos.producto')
            ->where('detallecompra.id_compra', $id)
            ->get();

        $fecha_compra = $data['compra']['created_at'];
        $data['fecha'] = date('d/m/Y', strtotime($fecha_compra));
        $data['hora'] = date('h:i A', strtotime($fecha_compra));
        // Generar el contenido del ticket en HTML
        $html = View::make('compra.ticket', $data)->render();
        //Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // Generar el PDF utilizando laravel-dompdf
        //$pdf = Pdf::loadHTML($html)->setPaper([0, 0, 226.77, 500], 'portrait')->setWarnings(false);
        $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 140, 500], 'portrait')->setWarnings(false);

        return $pdf->stream('ticket.pdf');
    }

    public function show()
    {
        return view('compra.show');
    }

    public function proveedor(Request $request)
    {
        $term = $request->get('term');
        $clients = Proveedor::where('nombre', 'LIKE', '%' . $term . '%')
            ->select('id', 'nombre AS label', 'telefono', 'direccion')
            ->limit(10)
            ->get();
        return response()->json($clients);
    }

    public function anular($compraId)
    {
        $userId = Auth::id();
        $existe = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();
        if ($existe) {
            try {
                // Iniciar una transacción
                DB::beginTransaction();

                // Buscar la compra por ID con sus detalles
                $compra = Compra::with('detallecompra')->findOrFail($compraId);

                // Iterar sobre los detalles y deshacer la cantidad en la tabla de productos
                foreach ($compra->detallecompra as $detalle) {
                    $producto = Producto::find($detalle->id_producto);
                    $producto->increment('stock', $detalle->cantidad);
                }

                // Actualizar el estado de la compra a 0
                $compra->update(['estado' => 0]);

                // Confirmar la transacción
                DB::commit();

                return redirect()->route('compra.show')
                    ->with('success', 'COMPRA ANULADA.');

            } catch (\Exception $e) {
                // Deshacer la transacción en caso de error
                DB::rollback();

                return redirect()->route('compra.show')
                    ->with('error', 'ERROR AL ANULAR');
            }
        } else {
            return redirect()->route('compra.show')
                    ->with('error', 'LA CAJA ESTA CERRADO');
        }
    }

    public function generateExcelReport()
    {
        return Excel::download(new CompraExport, 'compra.xlsx');
    }

    public function generatePdfReport()
    {
        $userId = Auth::id();

        $data['compras'] = Compra::with(['proveedor'])->where('id_usuario', $userId)->get();

        // Generar el contenido del ticket en HTML
        $html = View::make('compra.reporte', $data)->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }
}
