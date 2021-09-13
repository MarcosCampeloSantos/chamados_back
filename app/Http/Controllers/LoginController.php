<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function Login(LoginRequest  $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                $token = $user->createToken($request->email)->plainTextToken;
                return response()->json([
                    'mensagem' => 'Logado Com Sucesso!',
                    'auth_token' => $token 
                ]);
            }else{
                return   response()->json(['erro' => 'Senha Incorreta!'], 422);
            }
        }else{
            return response()->json(['erro' => 'Usuario Não Existe!'], 422);
        }
    }
}
