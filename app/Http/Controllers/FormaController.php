<?php

namespace App\Http\Controllers;

use App\Models\Forma;
use Illuminate\Http\Request;

/**
 * Class FormaController
 * @package App\Http\Controllers
 */
class FormaController extends Controller
{
    public function __construct() {
        $this->middleware('can:formas-pago.index')->only('index');
        $this->middleware('can:formas-pago.create')->only('create', 'store');
        $this->middleware('can:formas-pago.edit')->only('edit', 'update');
        $this->middleware('can:formas-pago.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('forma.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $forma = new Forma();
        return view('forma.create', compact('forma'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate(Forma::rules());

        $forma = Forma::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('formas.index')
            ->with('success', 'Forma pago creado.');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $forma = Forma::find($id);

        return view('forma.edit', compact('forma'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Forma $forma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Forma $forma)
    {
        request()->validate(Forma::rules($forma->id));

        $forma->update(
            [
                'nombre' => $request->nombre
            ]
        );

        return redirect()->route('formas.index')
            ->with('success', 'Forma pago actualizado');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        Forma::find($id)->delete();

        return redirect()->route('formas.index')
                    ->with('success', 'Forma pago eliminado');
    }
}
