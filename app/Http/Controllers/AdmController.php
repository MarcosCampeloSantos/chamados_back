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
use Illuminate\Support\Facades\Log;

class AdmController extends Controller
{

// Criação no Banco de Dados

    public function StoreDepartamento(DepRequest $request)
    {
        $departamento = new Departamento;
        $departamento->departamentos = $request->cria_dep;
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
        $user = User::where('id', $request->rel_user)->first();
        $relacionamentos = new Relacionamento();
        if(!Relacionamento::where('departamentos_id', $request->rel_dep)->where('topicos_id', '=', $request->rel_top)->first()){
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



//Edições / Exclusão de Dados

    public function EditarRel(Request $request)
    {
        $id_rel = $request->id_rel;
        $relacionamento = Relacionamento::where('id', $id_rel )->first();
        if ($relacionamento->id === $id_rel && !Relacionamento::where('departamentos_id', $request->dep)->where('topicos_id', $request->top)->first()) {
            $relacionamento->departamentos_id = $request->dep;
            $relacionamento->topicos_id = $request->top;
            $relacionamento->save();

            return response()->json('Relacionamento Editado com sucesso!');
        }else{
            return response()->json(['errors' => ['erro' => 'Relacionamento já Existe']], 422);
        }
    }

    public function AdcAtributo(Request $request)
    {
        if (!Atribuicoe::where('relacionamento_id', $request->id_rel)->where('user_id', $request->rel_user_edit)->first()) {
            $atributo = new Atribuicoe();
            $atributo->user_id = $request->rel_user_edit;
            $atributo->relacionamento_id = $request->id_rel;
            $atributo->save();

            return response()->json('Usuario Atribuido com Sucesso!');
        }else{
            return response()->json(['errors' => ['erro' => 'Usuario já Relacionado']], 422);
        }
        
    }

    public function ExcluirAtributo(Request $request)
    {
        $user = Atribuicoe::where('relacionamento_id', $request->id_rel)->where('user_id', $request->id_user)->first();    
        $user->delete();

        return response()->json('Usuario apagado com Sucesso!');
    }

    public function ExcluirRel(Request $request)
    {   
        Log::info($request);
        if($request->id){
            $atribuicoes = Atribuicoe::all();

            foreach ($atribuicoes as $top) {
                if($top->relacionamento_id == $request->id){
                    $top->delete();
                }
            }
            Relacionamento::destroy($request->id);

            return response()->json('Relacionamento apagado com Sucesso!');
        }else{
            return response()->json(['errors' => ['erro' => 'Ocorreu erro ao excluir o relacinamento!']], 422);
        }
    }

    public function ExcluirDep(Request $request)
    {
        if(!Relacionamento::where('departamentos_id', $request->id)->first()){
            $dep = Departamento::where('id', $request->id)->first();
            $dep->delete();

            return response()->json('Departamento apagado com Sucesso!');
        }else{
            return response()->json(['errors' => ['erro' => 'Não é possivel excluir, pois o departamento faz parte de um Relacionamento!']], 422);
        } 
    }

    public function ExcluirTop(Request $request)
    {
        if(!Relacionamento::where('topicos_id', $request->id)->first()){
            $top = Topico::where('id', $request->id)->first();
            $top->delete();

            return response()->json('Topico apagado com Sucesso!');
        }else{
            return response()->json(['errors' => ['erro' => 'Não é possivel excluir, pois o Topico faz parte de um Relacionamento!']], 422);
        }
    }
    // Busca no Banco de Dados

    public function BuscarDep()
    {
        $departamentos = Departamento::all();

        return response()->json($departamentos);
    }

    public function BuscarTop()
    {
        $topicos = Topico::all();

        return response()->json($topicos);
    }

    public function BuscarRel()
    {
        $relacionamentos = Relacionamento::all();
        $atribuicoes = [];
        $resultado = [];
        $atribuidos = [];
        $aux = [];

        foreach ($relacionamentos as $rel) {
            $departamentos = Departamento::with('relacionamentos')->find($rel->departamentos_id);
            $topicos = Topico::with('relacionamentos')->find($rel->topicos_id);
            $atribuidos = Atribuicoe::with('relacionamento')->get();
            foreach($atribuidos as $atrib){
                if($atrib->relacionamento_id == $rel->id){
                    $aux = User::with('atribuicoes')->find($atrib->user_id);
                    array_push($atribuicoes, $aux);
                }
            }
            
            $rel->atribuidos = $atribuicoes;
            $rel->departamento_name = $departamentos->departamentos;
            $rel->topico_name = $topicos->topicos;

            $atribuicoes = [];
        
            array_push($resultado, $rel);
        }
        
        
        return response()->json($resultado);
    }
    
}
