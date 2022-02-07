<?php

namespace App\Http\Controllers;

use App\Models\Atribuicoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AtribuicaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = DB::table('atribuicoes')
        ->join('topicos', 'topicos.id' ,'atribuicoes.topico_id')
        ->join('users', 'users.id', 'atribuicoes.user_id')
        ->select('users.name','topicos.topicos','atribuicoes.*')
        ->get();
        return response()->json($query);
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
        if(Atribuicoe::where('user_id', $request->user)->where('topico_id', $request->topico)->first()){
            return response()->json(['errors' => ['erro' => 'Usuario já Relacionado']], 422);
        }else{
            $atribuicao = new Atribuicoe();
            $atribuicao->user_id = $request->user;
            $atribuicao->topico_id = $request->topico;

            $atribuicao->save();
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
        //
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
        $atribuicao = Atribuicoe::find($id);
        $atribuicao->delete();
    }
}
