<?php

namespace App\Exports;

use App\Models\Proveedor;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProveedorsExport implements FromView
{
    public function view(): View
    {
        return view('proveedor.reporte', [
            //'company' => Compania::first(),
            'proveedores' => Proveedor::get()
        ]);
    }
}
