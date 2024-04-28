<?php

namespace App\Exports;

use App\Models\Caja;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class CajasExport implements FromView
{
    public function view(): View
    {
        $userId = Auth::id();
        return view('caja.reporte', [
            //'company' => Compania::first(),
            'cajas' => Caja::where('id_usuario', $userId)->get()
        ]);
    }
}
