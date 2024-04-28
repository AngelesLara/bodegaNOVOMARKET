<?php

namespace App\Http\Controllers;

use App\Exports\VentaExport;
use App\Models\Abonoventa;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Compania;
use App\Models\Creditoventa;
use App\Models\Detalleventa;
use App\Models\Forma;
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
 * Class VentaController
 * @package App\Http\Controllers
 */
class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formapagos = Forma::all();
        return view('venta.index', compact('formapagos'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();
        $existe = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();
        if ($existe) {
            $id_caja = $existe->id;
            $datosVenta = $request->all();
            $metodo = $datosVenta['metodo'];
            $id_cliente = $datosVenta['id_cliente'];
            $forma = $datosVenta['forma'];
            
            $pago_con = $datosVenta['pago_con'];
            //registrar venta
            $totalDecimal = Cart::instance('ventas')->subtotal();
            $total = str_replace(',', '', $totalDecimal);
            //COMPROBAR LIMITE
            if ($metodo == 'Credito') {
                $limite = $this->limitecliente($id_cliente);
                if ($limite < $total) {
                    return response()->json([
                        'title' => 'LIMITE DE CREDITO DISPONIBLE: ' . $limite,
                        'icon' => 'warning'
                    ]);
                }
            }
            
            if ($total > 0) {
                $pago_con = (empty($pago_con)) ? 0 : $pago_con;
                $sale = Venta::create([
                    'total' => $total,
                    'pago_con' => $pago_con,
                    'metodo' => $metodo,
                    'id_cliente' => $id_cliente,
                    'id_caja' => $id_caja,
                    'id_forma' => $forma,
                    'id_usuario' => $userId,
                ]);
                if ($sale) {
                    foreach (Cart::instance('ventas')->content() as $item) {
                        Detalleventa::create([
                            'precio' => $item->price,
                            'cantidad' => $item->qty,
                            'id_producto' => $item->id,
                            'id_venta' => $sale->id
                        ]);
                        // Actualizar el stock del producto
                        $producto = Producto::find($item->id);
                        if ($producto) {
                            // Verificar si hay suficiente stock antes de restar la cantidad
                            if ($producto->stock >= $item->qty) {
                                $producto->decrement('stock', $item->qty);
                            } else {
                                // Manejar el caso en el que no hay suficiente stock
                                // Puedes lanzar una excepción, mostrar un mensaje de error, etc.
                                // Aquí simplemente se incrementa el stock a 0.
                                $producto->update(['stock' => 0]);
                            }
                        }
                    }
                    //COMPRBAR METODO
                    if ($metodo == 'Credito') {
                        $credito = Creditoventa::create([
                            'monto' => $total,
                            'id_cliente' => $id_cliente,
                            'id_venta' => $sale->id,
                            'id_usuario' => $userId
                        ]);
                        //registrar abono inicial
                        if ($pago_con > 0) {
                            Abonoventa::create([
                                'monto' => $pago_con,
                                'id_caja' => $id_caja,
                                'id_forma' => $forma,
                                'id_credito' => $credito->id,
                                'id_usuario' => $userId,
                            ]);
                        }
                    }

                    Cart::instance('ventas')->destroy();
                    return response()->json([
                        'title' => 'VENTA GENERADA',
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
                'title' => 'LA CAJA ESTA CERRADA',
                'icon' => 'warning'
            ]);
        }
    }

    private function limitecliente($id_cliente)
    {
        $creditos = Creditoventa::select('id', 'monto')
            ->where('id_cliente', $id_cliente)
            ->with('abonos')
            ->get();

        $total = $creditos->sum('monto');
        $abonado = $creditos->flatMap(function ($credito) {
            return $credito->abonos->pluck('monto');
        })->sum();

        $cliente = Cliente::find($id_cliente);
        $restante = $cliente->credito - ($total - $abonado);

        return $restante;
    }

    public function ticket($id)
    {
        $data['company'] = Compania::first();

        $data['venta'] = Venta::with(['cliente', 'formapago'])
            ->where('id', $id)
            ->first();

        $data['productos'] = Detalleventa::join('productos', 'detalleventa.id_producto', '=', 'productos.id')
            ->select('detalleventa.*', 'productos.producto')
            ->where('detalleventa.id_venta', $id)
            ->get();

        $fecha_venta = $data['venta']['created_at'];
        $data['fecha'] = date('d/m/Y', strtotime($fecha_venta));
        $data['hora'] = date('h:i A', strtotime($fecha_venta));
        // Generar el contenido del ticket en HTML
        $html = View::make('venta.ticket', $data)->render();
        //Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // Generar el PDF utilizando laravel-dompdf
        //$pdf = Pdf::loadHTML($html)->setPaper([0, 0, 226.77, 500], 'portrait')->setWarnings(false);
        $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 140, 500], 'portrait')->setWarnings(false);

        return $pdf->stream('ticket.pdf');
    }

    public function show()
    {
        return view('venta.show');
    }

    public function cliente(Request $request)
    {
        $term = $request->get('term');
        $clients = Cliente::where('nombre', 'LIKE', '%' . $term . '%')
            ->select('id', 'nombre AS label', 'telefono', 'direccion')
            ->limit(10)
            ->get();
        return response()->json($clients);
    }

    public function anular($ventaId)
    {
        $userId = Auth::id();
        $existe = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();
        if ($existe) {
            try {
                // Iniciar una transacción
                DB::beginTransaction();

                // Buscar la venta por ID con sus detalles
                $venta = Venta::with('detalleventa')->findOrFail($ventaId);

                // Iterar sobre los detalles y deshacer la cantidad en la tabla de productos
                foreach ($venta->detalleventa as $detalle) {
                    $producto = Producto::find($detalle->id_producto);
                    $producto->decrement('stock', $detalle->cantidad);
                }

                // Actualizar el estado de la venta a 0
                $venta->update(['estado' => 0]);

                // Confirmar la transacción
                DB::commit();

                return redirect()->route('venta.show')
                    ->with('success', 'VENTA ANULADA');
            } catch (\Exception $e) {
                // Deshacer la transacción en caso de error
                DB::rollback();

                return redirect()->route('venta.show')
                    ->with('error', 'ERROR AL ANULAR');
            }
        } else {
            return redirect()->route('venta.show')
                    ->with('error', 'LA CAJA ESTA CERRADO');
        }
    }

    public function generateExcelReport()
    {
        return Excel::download(new VentaExport, 'venta.xlsx');
    }

    public function generatePdfReport()
    {
        $userId = Auth::id();

        $data['ventas'] = Venta::with(
            [
                'cliente',
                'formapago'
            ]
        )->where('id_usuario', $userId)->get();

        $html = View::make('venta.reporte', $data)
        ->render();

        $pdf = Pdf::loadHTML($html)
        ->setPaper('a4', 'landscape')
        ->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }
}
