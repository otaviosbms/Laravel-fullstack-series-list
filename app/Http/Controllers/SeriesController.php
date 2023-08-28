<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated as SeriesCreatedEvent;
use App\Http\Middleware\Autenticador;
use App\Http\Middleware\Authenticate;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SeriesController extends Controller
{

    public function __construct(private SeriesRepository $repository)
    {

        $this->middleware(Autenticador::class)->except('index');

    }

    public function index()
    {

        Auth::check();

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

        $coverPath = $request->file('cover')->store('series_cover','public');
        $request->coverPath = $coverPath;

        $serie = $this->repository->add($request);

        SeriesCreatedEvent::dispatch(
            $serie->nome,
            $serie->id,
            $request->seasonsQty,
            $request->episodesPerSeason,
        );


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
