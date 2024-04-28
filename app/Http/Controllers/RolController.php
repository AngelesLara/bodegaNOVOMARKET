<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RolController extends Controller
{

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        return view('usuario.rol', compact('user', 'roles'));
    }

    public function update(Request $request, User $user) {
        $user->roles()->sync($request->roles);

        return redirect()->route('rol.edit', $user->id)->with('info', 'Rol asignado');
    }
}
