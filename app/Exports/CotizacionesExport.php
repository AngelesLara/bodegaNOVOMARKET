<?php

namespace App\Exports;

use App\Models\Cotizacion;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class CotizacionesExport implements FromView
{
    public function view(): View
    {
        $userId = Auth::id();
        return view('cotizacion.reporte', [
            //'company' => Compania::first(),
            'cotizaciones' => Cotizacion::with(['cliente'])->where('id_usuario', $userId)->get()
        ]);
    }
}
