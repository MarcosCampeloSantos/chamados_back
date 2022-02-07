<?php

namespace App\Http\Controllers;

use App\Models\Anexo;
use App\Models\Atribuicoe;
use App\Models\Chamado;
use App\Models\Interacoe;
use App\Models\Relacionamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChamadoController extends Controller
{
    public function index(Request $request)
    {
        Log::info($request);
        if($request->adm && $request->todos){
            $query = DB::table('chamados')
                    ->join('users', 'users.id', 'chamados.user_id')
                    ->join('topicos', 'topicos.id', 'chamados.topico_id')
                    ->where('chamados.estado', '!=', 'FECHADO')
                    ->select('users.name', 'chamados.*', 'topicos.topicos')
                    ->orderBy('id')
                    ->get();

            $query2 = DB::table('anexos')
                        ->join('interacoes', 'interacoes.id', 'anexos.interacoe_id')
                        ->join('chamados', 'chamados.id', 'interacoes.chamado_id')
                        ->select('anexos.id', 'chamados.id as chamado_id')
                        ->get();

            
        }elseif($request->adm && $request->fechado){
            $query = DB::table('chamados')
                    ->join('users', 'users.id', 'chamados.user_id')
                    ->join('topicos', 'topicos.id', 'chamados.topico_id')
                    ->where('chamados.estado', 'FECHADO')
                    ->select('users.name', 'chamados.*', 'topicos.topicos')
                    ->orderBy('id')
                    ->get();

            $query2 = DB::table('anexos')
                    ->join('interacoes', 'interacoes.id', 'anexos.interacoe_id')
                    ->join('chamados', 'chamados.id', 'interacoes.chamado_id')
                    ->select('anexos.id', 'chamados.id as chamado_id')
                    ->get();
        }elseif($request->adm && $request->relacionado){
            $query = DB::table('chamados')
                    ->join('users', 'users.id', 'chamados.user_id')
                    ->join('topicos', 'topicos.id', 'chamados.topico_id')
                    ->join('atribuicoes', 'atribuicoes.topico_id', 'chamados.topico_id')
                    ->where('atribuicoes.user_id', $request->user_id)
                    ->where('chamados.estado', '!=', 'FECHADO')
                    ->select('users.name', 'chamados.*', 'topicos.topicos', 'atribuicoes.user_id as atribuido')
                    ->orderBy('id')
                    ->get();

            $query2 = DB::table('anexos')
                    ->join('interacoes', 'interacoes.id', 'anexos.interacoe_id')
                    ->join('chamados', 'chamados.id', 'interacoes.chamado_id')
                    ->select('anexos.id', 'chamados.id as chamado_id')
                    ->get();
        }

        $countAll = DB::table('chamados')
                    ->join('users', 'users.id', 'chamados.user_id')
                    ->join('topicos', 'topicos.id', 'chamados.topico_id')
                    ->where('chamados.estado', '!=', 'FECHADO')
                    ->select('users.name', 'chamados.*', 'topicos.topicos')
                    ->orderBy('id')
                    ->count();

        $countclosed = DB::table('chamados')
                    ->join('users', 'users.id', 'chamados.user_id')
                    ->join('topicos', 'topicos.id', 'chamados.topico_id')
                    ->where('chamados.estado', 'FECHADO')
                    ->select('users.name', 'chamados.*', 'topicos.topicos')
                    ->orderBy('id')
                    ->count();

        $countatribuido = DB::table('chamados')
                        ->join('users', 'users.id', 'chamados.user_id')
                        ->join('topicos', 'topicos.id', 'chamados.topico_id')
                        ->join('atribuicoes', 'atribuicoes.topico_id', 'chamados.topico_id')
                        ->where('chamados.estado','!=','FECHADO')
                        ->where('atribuicoes.user_id', $request->user_id)
                        ->select('users.name', 'chamados.*', 'topicos.topicos', 'atribuicoes.user_id as atribuido')
                        ->orderBy('id')
                        ->count();


        $chamado_anexo = [];
        foreach ($query as $key) {
            foreach ($query2 as $key2) {
                if ($key->id == $key2->chamado_id) {
                    if($chamado_anexo == []){
                        array_push($chamado_anexo, $key->id);
                    }else{
                        for ($i=0; $i < count($chamado_anexo); $i++) { 
                            if($chamado_anexo[$i] == $key->id){
                                break 2;
                            }else{
                                array_push($chamado_anexo, $key->id);
                            }
                        }
                    }
                }
            }
        }
        
        return response()->json(['chamados' => $query, 'anexos' => $query2, 'chamado_anexo' => $chamado_anexo, 'count' => ['all' => $countAll, 'close' => $countclosed, 'atribuido' => $countatribuido]]);
    }

    public function store(Request $request)
    {
        $chamado = new Chamado;
        $interacoes = new Interacoe;
        $anexo = new Anexo;

        if(empty($request->Imagem)){
            $chamado->title = $request->titulo;
            $chamado->topico_id = $request->topico;
            $chamado->user_id = $request->user_id;
            $chamado->estado = $request->chamado_estado;
            $chamado->departamento = $request->departamento;

            $chamado->save();

            $interacoes->user_id = $request->user_id;
            $interacoes->chat = $request->conteudo;

            $ultimoChamado = $chamado->orderBy('id','desc')->where('user_id', $request->user_id)->first();

            $interacoes->chamado_id = $ultimoChamado->id;
            $interacoes->save();

        }else{
            $ultimoChamado = $chamado->orderBy('id','desc')->where('user_id', $request->idUser)->first();
            $ultimaInteracao = $interacoes->orderBy('id','desc')->where('user_id', $request->idUser)->first();

            $anexo->anexo = $request->file('Imagem')->store('Anexos', 'public');
            $anexo->nameanexo = $request->Name;
            $anexo->user_id = $request->idUser;
            $anexo->chamado_id = $ultimoChamado->id;

            $anexo->interacoe_id = $ultimaInteracao->id;

            $anexo->save();
        }

        
        return response()->json("Sucesso");
        
    }

    public function show($dados)
    {
        
    }
}
