<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopRequest;
use App\Models\Atribuicoe;
use App\Models\Topico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TopicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topicos = Topico::all();

        return response()->json($topicos);
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
    public function store(TopRequest $request)
    {
        Log::info($request);
        $topicos = new Topico;
        $topicos->topicos = $request->name_topico;

        $topicos->save();
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
        if(Atribuicoe::where('topico_id', $id)->first()){
            return response()->json(['errors' => ['erro' => 'Não é possivel excluir, pois o Topico está atribuido a algum usuario']], 422);
        }else{
            $top = Topico::where('id', $id)->first();
            $top->delete();
            
        }
    }
}
