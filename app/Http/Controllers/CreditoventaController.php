<?php

namespace App\Http\Controllers;

use App\Exports\CreditoventaExport;
use App\Models\Abonoventa;
use App\Models\Caja;
use App\Models\Cliente;
use App\Models\Compania;
use App\Models\Creditoventa;
use App\Models\Forma;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\View;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class CreditoventaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $formapagos = Forma::all();
        return view('venta.creditos.index', compact('formapagos'));
    }

    public function abonos($id)
    {
        $formapagos = Forma::all();
        $credito = Creditoventa::with('venta.cliente')->findOrFail($id);
        $abonos = Abonoventa::with('formapago', 'usuario')->where('id_credito', $id)->orderBy('id', 'desc')->paginate(10);
        $abonado = 0;

        $creditos = Creditoventa::with('abonos')
            ->where('id', $id)
            ->get();

        foreach ($creditos as $credito) {
            $abonado = $credito->abonos->sum('monto');
        }

        return view('venta.creditos.abonos', compact('abonos', 'credito', 'formapagos', 'abonado'));
    }

    public function detalle($id_credito)
    {
        $abonado = Abonoventa::where('id_credito', $id_credito)->sum('monto');
        $credito = Creditoventa::with('cliente')->find($id_credito);

        $total = $credito->monto;

        $restante = $total - $abonado;

        $data = [
            'cliente' => ['nombre' => $credito->cliente->nombre, 'telefono' => $credito->cliente->telefono],
            'credito' => ['abonado' => $abonado, 'restante' => $restante, 'total' => $total],
        ];

        return response()->json($data);
    }

    public function limitecliente($id_cliente)
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

        return response()->json($restante);
    }

    public function registrarAbono(Request $request)
    {
        $userId = Auth::id();
        $existe = Caja::where('id_usuario', $userId)
            ->where('estado', 1)->first();

        if (!$existe) {
            return response()->json([
                'title' => 'LA CAJA ESTA CERRADA',
                'icon' => 'warning'
            ]);
        }

        //COMPROBAR RESTANTE
        $abonado = Abonoventa::where('id_credito', $request->input('id_credito'))->sum('monto');
        $totalCredito = Creditoventa::find($request->input('id_credito'));

        // Asegúrate de que se encontró el crédito
        if (!$totalCredito) {
            return response()->json([
                'icon' => 'error',
                'title' => 'No se encontró el crédito.'
            ]);
        }

        // Obtén el monto del crédito
        $total = $totalCredito->monto;

        $restante = $total - $abonado;

        if ($request->input('monto') > $restante) {
            return response()->json([
                'icon' => 'warning',
                'title' => 'Ingresó un monto menor al restante. ' . $restante
            ]);
        }

        // Crear una instancia del modelo Abono
        $abono = new Abonoventa();
        $abono->monto = $request->input('monto');
        $abono->id_caja = $existe->id;
        $abono->id_forma = $request->input('forma');
        $abono->id_usuario = $userId;
        $abono->id_credito = $request->input('id_credito');

        // Guardar el abono en la base de datos
        $abono->save();

        // Devolver una respuesta de éxito
        return response()->json([
            'icon' => 'success',
            'title' => 'Abono registrado correctamente.',
            'ticket' => $abono->id,
        ]);
    }

    public function ticket($id)
    {
        $data['company'] = Compania::first();

        $data['abono'] = Abonoventa::with('creditoventa.venta.cliente', 'formapago')->findOrFail($id);

        $id_credito = $data['abono']->creditoventa->id;

        $data['abonado'] = 0;

        $creditos = Creditoventa::with('abonos')
            ->where('id', $id_credito)
            ->get();
        foreach ($creditos as $credito) {
            $abonos_hasta_id = $credito->abonos->filter(function ($abono) use ($id) {
                return $abono->id <= $id;
            });
            $data['abonado'] = $abonos_hasta_id->sum('monto');
        }
        // Generar el contenido del ticket en HTML
        $html = View::make('venta.creditos.ticket', $data)->render();
        //Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        // Generar el PDF utilizando laravel-dompdf
        //$pdf = Pdf::loadHTML($html)->setPaper([0, 0, 226.77, 500], 'portrait')->setWarnings(false);
        $pdf = Pdf::loadHTML($html)->setPaper([0, 0, 140, 500], 'portrait')->setWarnings(false);

        return $pdf->stream('ticket.pdf');
    }
    public function generateExcelReport()
    {
        return Excel::download(new CreditoventaExport, 'creditos.xlsx');
    }

    public function generatePdfReport()
    {
        $userId = Auth::id();

        $consulta = Venta::with('creditos.abonos', 'cliente')
            ->where('id_usuario', $userId)
            ->get();

        $creditos = [];

        foreach ($consulta as $venta) {

            foreach ($venta->creditos as $credito) {

                $abonado = $credito->abonos->sum('monto');
                $restante = $venta->total - $abonado;

                $creditos[] = [
                    'id' => $credito->id,
                    'total' => number_format($venta->total, 2),
                    'nombre' => $venta->cliente->nombre,
                    'telefono' => $venta->cliente->telefono,
                    'abonado' => number_format($abonado, 2),
                    'restante' => number_format($restante, 2),
                    'fecha' => $credito->created_at->format('Y-m-d H:i:s'),
                ];
            }
        }

        // Generar el contenido del ticket en HTML
        $html = View::make('venta.creditos.reporte', compact('creditos'))->render();

        // Generar el PDF utilizando laravel-dompdf con orientación horizontal
        $pdf = Pdf::loadHTML($html)->setPaper('a4', 'landscape')->setWarnings(false);

        return $pdf->stream('reporte.pdf');
    }
}
