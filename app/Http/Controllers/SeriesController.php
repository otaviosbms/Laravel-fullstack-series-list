<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Serie::query()->orderBy('nome')->get();
        $mensagemSucesso = session('mensagem.sucesso');


        return view('series.index')->with('series', $series)->with('mensagemSucesso',$mensagemSucesso);
    }


    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $serie = Serie::create($request->all()); // preenche todos os campos com a informação request, exeto o token, devido a prpriedade fillable no model

        return to_route('series.index')->with('mensagem.sucesso',"Série '{$serie->nome}' adicionada com sucesso");

    }

    public function destroy(Serie $serie)
    {

        $serie->delete();


        return to_route('series.index')
            ->with('mensagem.sucesso',"Série '{$serie->nome}' removida com sucesso");
    }

    public function edit(int $id)
    {
        $series = Serie::findOrFail($id);
        return view('series.edit')->with('serie', $series);

    }

    public function update(int $id, Request $request)
    {
        $series = Serie::findOrFail($id);
        $series->nome = $request->nome;
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso',"Série '{$series->nome}' atualizada com sucesso");
    }

}