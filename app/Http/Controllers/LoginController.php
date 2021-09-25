<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
                    'auth_token' => $token,
                    'user' => $user
                ]);
            }else{
                return   response()->json(['erro' => 'Senha Incorreta!'], 422);
            }
        }else{
            return response()->json(['erro' => 'Usuario Não Existe!'], 422);
        }
    }

    public function Logout(Request $request)
    {
        $userId = $request->input('dados.user.id');
        $user = User::where('id', $userId)->first();
        $token = $request->input('dados.auth_token');
        $tokenId = explode("|", $token);
        $user->tokens()->where('id', $tokenId[0])->delete();

        return response()->json(['Deslogado']);
    }

    public function Verificacao(Request $request)
    {
        // $token = explode('|', $request->auth_token);
        // $email = $request->input('user.email');

        // $user = User::where('email', $email)->first();
        
    }
}
