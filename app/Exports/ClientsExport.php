<?php

namespace App\Exports;

use App\Models\Cliente;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ClientsExport implements FromView
{
    public function view(): View
    {
        return view('cliente.reporte', [
            //'company' => Compania::first(),
            'clientes' => Cliente::get()
        ]);
    }
}
