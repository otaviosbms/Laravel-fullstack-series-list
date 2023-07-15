<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesRepository
{
    public function add(SeriesFormRequest $request): Series
    {
        return DB::Transaction(function() use ($request) {

            $serie = Series::create($request->all()); // preenche todos os campos com a informação request, exeto o token, devido a prpriedade fillable no model
            $seasons = [];
            for($i = 1; $i <= $request->seasonsQty; $i++){
                $seasons[] = [
                    'series_id' => $serie->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach($serie->seasons as $season){

                for($j = 1; $j <= $request->episodesPerSeason; $j++){
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                }

            }

            Episode::insert($episodes);

            return $serie;

        });
    }




}
