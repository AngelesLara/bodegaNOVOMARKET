<?php

namespace App\Exports;

use App\Models\Producto;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProductsExport implements FromView
{
    public function view(): View
    {
        return view('producto.reporte', [
            //'company' => Compania::first(),
            'productos' => Producto::with(['categoria'])->get()
        ]);
    }
}
