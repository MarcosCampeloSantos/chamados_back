<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepRequest;
use App\Http\Requests\RelRequest;
use App\Http\Requests\TopRequest;
use App\Models\Atribuicoe;
use App\Models\Departamento;
use App\Models\Relacionamento;
use App\Models\Topico;
use App\Models\User;
use Illuminate\Http\Request;

class AdmController extends Controller
{

    // Criação no Banco de Dados
    public function StoreDepartamento(DepRequest $request)
    {
        $departamento = new Departamento;
        $departamento->departamento = $request->cria_dep;
        $departamento->menssageremail = $request->cria_dep_email;

        $departamento->save();

        return response()->json('Departamento cadastrado com sucesso!');
    }

    public function StoreTopicos(TopRequest $request)
    {
        $topicos = new Topico;
        $topicos->topicos = $request->cria_top;

        $topicos->save();

        return response()->json('Topico cadastrado com sucesso!');
    }

    public function StoreRelaciomento(RelRequest $request)
    {
        $atribuicao = new Atribuicoe;
        $user = User::where('id', '=', $request->rel_user)->first();
        $relacionamentos = new Relacionamento();
        if(!Relacionamento::where('departamentos_id', '=', $request->rel_dep)->where('topicos_id', '=', $request->rel_top)->first()){
            $relacionamentos->departamentos_id = $request->rel_dep;
            $relacionamentos->topicos_id = $request->rel_top;
            $relacionamentos->save();

            $atribuicao->user_id = $user->id;
            $atribuicao->relacionamento_id = $relacionamentos->id;
            $atribuicao->save();

            return response()->json('Relacionamento criado com sucesso!');
        }else{
            return response()->json(['errors' => ['erro' => 'Relacionamento já Existe']], 422);
        }
    }


    // Busca no Banco de Dados
    public function BuscarDep()
    {
        $departamento = Departamento::all();

        return response()->json($departamento);
    }

    public function BuscarTop()
    {
        $topicos = Topico::all();

        return response()->json($topicos);
    }

    public function BuscarRel()
    {
        $relacionamentos = Relacionamento::all();
        $usuarios = User::all();
        $atribuicoes = Atribuicoe::all();
        $resultado = [];
        $atribuidos = [];
        $teste = [];

        $i = 1;
        foreach ($relacionamentos as $rel) {
            $departamentos = Departamento::with('relacionamentos')->find($i);
            $topicos = Topico::with('relacionamentos')->find($i);
            $atribuidos = Atribuicoe::with('relacionamento')->get();
            foreach($atribuidos as $atrib){
                if($atrib->relacionamento_id == $rel->id){
                    array_push($teste, $atrib->id);
                }
            }
            $rel->teste = $teste;
            $teste = [];
            $rel->departamento_name = $departamentos->departamento;
            $rel->topico_name = $topicos->topicos;
            array_push($resultado, $rel);
            $i++;
        }
        
        
        return response()->json($resultado);
    }
    
}
