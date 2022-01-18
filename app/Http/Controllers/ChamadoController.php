<?php

namespace App\Http\Controllers;

use App\Models\Anexo;
use App\Models\Chamado;
use App\Models\Interacoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChamadoController extends Controller
{
    public function index(Request $request)
    {
        if($request->Adm){
            $query = DB::table('chamados')
                    ->join('users', 'users.id', 'chamados.user_id')
                    ->join('topicos', 'topicos.id', 'chamados.topico_id')
                    ->select('users.name', 'chamados.*', 'topicos.topicos')
                    ->get();

            $query2 = DB::table('anexos')
                        ->join('interacoes', 'interacoes.id', 'anexos.interacoe_id')
                        ->join('chamados', 'chamados.id', 'interacoes.chamado_id')
                        ->select('anexos.id', 'chamados.id as chamado_id')
                        ->get();
        }
        
        return response()->json(['chamados' => $query, 'anexos' => $query2]);
        Log::info($query);
    }

    public function store(Request $request)
    {
        $chamado = new Chamado;
        $interacoes = new Interacoe;
        $anexo = new Anexo;

        if(empty($request->Imagem)){
            $chamado->title = $request->titulo;
            $chamado->topico_id = $request->top;
            $chamado->user_id = $request->user_id;
            $chamado->estado_id = $request->estado_id;
            $chamado->departamento_id = $request->departamento_id;

            $chamado->save();

            $interacoes->user_id = $request->user_id;
            $interacoes->chat = $request->conteudo;

            $ultimoChamado = $chamado->orderBy('id','desc')->where('user_id', $request->user_id)->first();

            $interacoes->chamado_id = $ultimoChamado->id;
            $interacoes->save();

        }else{
            $anexo->anexo = $request->file('Imagem')->store('Anexos', 'public');
            $anexo->nameanexo = $request->Name;
            $anexo->user_id = $request->idUser;

            $ultimaInteracao = $interacoes->orderBy('id','desc')->where('user_id', $request->idUser)->first();

            $anexo->interacoe_id = $ultimaInteracao->id;

            $anexo->save();
        }

        
        return response()->json("Sucesso");
        
    }
}
