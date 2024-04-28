<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

/**
 * Class ClienteController
 * @package App\Http\Controllers
 */
class ClienteController extends Controller
{
    public function __construct() {
        $this->middleware('can:clientes.index')->only('index');
        $this->middleware('can:clientes.create')->only('create', 'store');
        $this->middleware('can:clientes.edit')->only('edit', 'update');
        $this->middleware('can:clientes.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cliente.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = new Cliente();
        return view('cliente.create', compact('cliente'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Cliente::rules());

        $cliente = Cliente::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'credito' => $request->credito,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente creado.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cliente = Cliente::find($id);

        return view('cliente.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Cliente $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        request()->validate(Cliente::rules($cliente->id));
        $cliente->update(
            [
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'credito' => $request->credito,
                'direccion' => $request->direccion,
            ]
        );

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Cliente::find($id)->delete();
        return redirect()->route('clientes.index')
        ->with('success', 'Cliente eliminado.');
    }
}
