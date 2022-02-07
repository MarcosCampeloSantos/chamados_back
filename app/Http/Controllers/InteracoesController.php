<?php

namespace App\Http\Controllers;

use App\Models\Anexo;
use App\Models\Chamado;
use App\Models\Interacoe;
use App\Models\User;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InteracoesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $interacoes = new Interacoe;
        $anexo = new Anexo();

        if($request->user){
            $user = User::find($request->user);
        }
        
        if($request->id_chamado){
            $chamado = Chamado::find($request->id_chamado);
        }
        
        if(empty($request->Imagem)){
            if(($request->status_atual == 'ABERTO' || $request->status_atual == 'FECHADO') && ($request->operador || $request->adm)){
                $chamado->estado = 'EM ATENDIMENTO';
                $user->id_chamado = $chamado->id;

                $interacoes->chamado_id = $request->id_chamado;
                $interacoes->user_id = $request->user;
                $interacoes->chat = $request->chat;
                
                $interacoes->save();
            }else{
                $chamado->estado = $request->status_novo; 
                
                
                if($request->status_atual != 'ABERTO'){
                    $interacoes->chamado_id = $request->id_chamado;
                    $interacoes->user_id = $request->user;
                    $interacoes->chat = $request->chat;
                    
                    $interacoes->save();
                }
            }

            $chamado->save(); 
            $user->save();
        }else {
            $ultimaInteracao = $interacoes->orderBy('id','desc')->where('user_id', $request->idUser)->first();

            $anexo->anexo = $request->file('Imagem')->store('Anexos', 'public');
            $anexo->nameanexo = $request->Name;
            $anexo->user_id = $request->idUser;
            $anexo->chamado_id = $ultimaInteracao->chamado_id;

            $anexo->interacoe_id = $ultimaInteracao->id;

            $anexo->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $queryinteracoes = DB::table('interacoes')
        ->join('users', 'users.id', 'interacoes.user_id')
        ->select('users.name as nome_chat', 'interacoes.*')
        ->where('interacoes.chamado_id', $id)
        ->orderByDesc('created_at')
        ->get();

        $queryanexos = DB::table('interacoes')
        ->join('anexos', 'anexos.interacoe_id', 'interacoes.id')
        ->select('anexos.*')
        ->where('interacoes.chamado_id', $id)->get();

        return response()->json(['interacoes' => $queryinteracoes, 'anexos' => $queryanexos]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
