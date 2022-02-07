<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsuarioController extends Controller
{
    public function StoreUsuario(UsuarioRequest $request)
    {
        $usuario = new User;
        $usuario->name = $request->name;
        $usuario->departamento = $request->departamento;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->password);
        $usuario->nivel = $request->nivel;

        $usuario->save();

    }

    public function BuscarUsers()
    {
        $usuario = User::all();

        return response()->json($usuario);
    }

    public function ModoOperador(Request $request)
    {
        Log::info($request);

        $user = User::find($request->id_usuario);

        if($request->modo_acesso == true){
            $user->operador = true;
        }else{
            $user->operador = false;
        }
        

        $user->save();

        return response()->json([
            'user' => $user
        ]);
    }
}
