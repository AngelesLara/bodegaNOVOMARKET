<?php

namespace App\Exports;

use App\Models\Compania;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class VentaExport implements FromView
{
    public function view(): View
    {
        $userId = Auth::id();
        return view('venta.reporte', [
            //'company' => Compania::first(),
            'ventas' => Venta::with(['cliente', 'formapago'])->where('id_usuario', $userId)->get()
        ]);
    }
}
