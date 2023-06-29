<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index()
    {
        $series = Series::all();
        $mensagemSucesso = session('mensagem.sucesso');


        return view('series.index')->with('series', $series)->with('mensagemSucesso',$mensagemSucesso);
    }


    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {

        $serie = Series::create($request->all()); // preenche todos os campos com a informação request, exeto o token, devido a prpriedade fillable no model

        return to_route('series.index')->with('mensagem.sucesso',"Série '{$serie->nome}' adicionada com sucesso");

    }

    public function destroy(Request $request, Series $serie)
    {

        $serie->delete();

        Series::destroy($request->series);

        return to_route('series.index')
            ->with('mensagem.sucesso',"Série '{$serie->nome}' removida com sucesso");

    }

    public function edit(Series $series)
    {
        dd($series->temporadas());
        return view('series.edit')->with('serie', $series);

    }

    public function update(Series $series, SeriesFormRequest $request)
    {


        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
            ->with('mensagem.sucesso',"Série '{$series->nome}' atualizada com sucesso");
    }

}
