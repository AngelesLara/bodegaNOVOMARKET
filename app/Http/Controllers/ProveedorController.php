<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

/**
 * Class ProveedorController
 * @package App\Http\Controllers
 */
class ProveedorController extends Controller
{
    public function __construct() {
        $this->middleware('can:proveedores.index')->only('index');
        $this->middleware('can:proveedores.create')->only('create', 'store');
        $this->middleware('can:proveedores.edit')->only('edit', 'update');
        $this->middleware('can:proveedores.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('proveedor.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $proveedor = new Proveedor();
        return view('proveedor.create', compact('proveedor'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Proveedor::rules());

        $proveedor = Proveedor::create([
            'identidad' => $request->identidad,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
            'direccion' => $request->direccion,
        ]);

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor creado.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $proveedor = Proveedor::find($id);
        return view('proveedor.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Proveedor $proveedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $proveedor = Proveedor::find($id);
        request()->validate(Proveedor::rules($id));
        $proveedor->update(
            [
                'identidad' => $request->identidad,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'correo' => $request->correo,
                'direccion' => $request->direccion,
            ]
        );

        return redirect()->route('proveedores.index')
            ->with('success', 'Proveedor actualizado');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Proveedor::find($id)->delete();
        return redirect()->route('proveedores.index')
        ->with('success', 'Proveedor eliminado.');
    }
}