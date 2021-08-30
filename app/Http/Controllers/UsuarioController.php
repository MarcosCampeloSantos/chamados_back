<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function StoreUsuario(UsuarioRequest $request)
    {
        $usuario = new User;
        $usuario->name = $request->name;
        $usuario->departamento = $request->departamento;
        $usuario->email = $request->email;
        $usuario->password = $request->password;
        $usuario->nivel = $request->nivel;

        $usuario->save();

        return response()->json('Usuario criado com Sucesso!');
    }

    public function BuscarUsers()
    {
        $usuario = User::all();

        return response()->json($usuario);
    }
}
