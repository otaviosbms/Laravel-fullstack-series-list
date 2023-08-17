<?php

namespace App\Http\Controllers;

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

        $serie = $this->repository->add($request);

        $userList = User::all();

        foreach ($userList as $user){

            $email = new SeriesCreated(
                $serie->nome,
                $serie->id,
                $request->seasonsQty,
                $request->episodesPerSeason
            );
    
            Mail::to($user)->queue($email); // queue enfilera os emaails para que todos eles sejam mandados após o termino da requisição 

            // sleep(2); // adiciona um delay na execução do loop
        }

        
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
