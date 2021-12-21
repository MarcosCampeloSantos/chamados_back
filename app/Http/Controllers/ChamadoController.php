<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use App\Models\Interacoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChamadoController extends Controller
{
    public function StoreChamado(Request $request)
    {
        Log::info($request);
        // $chamado = new Chamado;
        // $intercoes = new Interacoe;

        // $chamado->title = $request->titulo;
        // $chamado->topico = $request->top;
        // $chamado->user_id = $request->user_id;
        // $chamado->estado_id = $request->estado_id;
        // $chamado->departamento_id = $request->departamento_id;

        // $chamado->save();

        // if(!empty($request->anexo)){
        //     $requestarquivo = $request->anexo;
        //     $nomearquivo = $requestarquivo->getClientOriginalName();
        //     $request->anexo->move(public_path('anexos'), $nomearquivo);

        //     $intercoes->anexo = $nomearquivo;
        //     $intercoes->nameanexo = $requestarquivo->getClientOriginalName();
        // }

        // $intercoes->user_id = $request->user_id;
        // $intercoes->chat = $request->conteudo;
        // $intercoes->chamado_id = $chamado->id;

        // $intercoes->save();
    }
}
