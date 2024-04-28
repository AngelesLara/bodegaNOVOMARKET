<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function __construct() {
        $this->middleware('can:usuarios.index')->only('index');
        $this->middleware('can:usuarios.create')->only('create', 'store');
        $this->middleware('can:usuarios.edit')->only('edit', 'update');
        $this->middleware('can:usuarios.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuario.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = new User();
        return view('usuario.create', compact('usuario'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|min:6'
        ]);

        $usuario = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario creado.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $usuario = User::find($id);

        return view('usuario.edit', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  User $usuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $usuario)
    {
        request()->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $usuario->id,
            'password' => 'nullable|min:6'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        
        // Actualiza la contraseña solo si se proporciona un nuevo valor
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $usuario->update($data);

        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('usuarios.index')
        ->with('success', 'Usuario eliminado.');
    }
}
