<?php

namespace App\Exports;

use App\Models\Compania;
use App\Models\Compra;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CompraExport implements FromView
{
    public function view(): View
    {
        $userId = Auth::id();
        return view('compra.reporte', [
            //'company' => Compania::first(),
            'compras' => Compra::with(['proveedor'])->where('id_usuario', $userId)->get()
        ]);
    }
}
