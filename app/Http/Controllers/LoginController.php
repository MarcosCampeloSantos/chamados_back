<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    public function Login(LoginRequest  $request)
    {
        $user = User::where('email', $request->email)->first();
        if($user){
            if(Hash::check($request->password, $user->password)){
                return response()->json([
                    'auth_token' => $user->createToken($request->email)->plainTextToken,
                    'user' => $user
                ]);
            }else{
                return response()->json(['erro' => 'Senha Incorreta!'], 422);
            }
        }else{
            return response()->json(['erro' => 'Usuario Não Existe!'], 422);
        }
    }

    public function Logout(Request $request)
    {
        
        $userId = $request->input('dados.user.id');
        $user = User::where('id', $userId)->first();
        $user->tokens()->delete();

        return response()->json(['Deslogado']);
    }

    public function Verificacao(Request $request)
    {
        if($request->auth_token){
            $token = explode('|', $request->auth_token);
            $user_id = $request->input('user.id');
            $user = User::where('id', $user_id)->first();
            $tokens = $user->tokens()->get();
            
            foreach ($tokens as $chaves) {
                if($chaves->id == $token[0]){
                    return response()->json(['Verificacao' => 'true']);
                }
            }
            return response()->json(['erro' => 'Não Autorizado'], 500);
        }else{
            return response()->json(['erro' => 'Não Autorizado'], 500);
        }
        
    }
}
