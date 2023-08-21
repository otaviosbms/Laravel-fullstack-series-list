<?php

namespace App\Listeners;


use App\Events\SeriesCreated as SeriesCreatedEvent;
use App\Mail\SeriesCreated;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmailUsersAboutSeriesCreated
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     */
    public function handle(SeriesCreatedEvent $event): void
    {
        $userList = User::all();

        foreach ($userList as $index => $user){

            $email = new SeriesCreated(
                $event->seriesName,
                $event->seriesId,
                $event->seriesSeasonQty,
                $event->seriesEpisodesPerSeason
            );

            $when = now()->addSeconds($index * 5); //adiciona 5 segundos a mais na hora atual para o envio de emails.
    
            // alterações feitas para se adequear ao processamento de emails do Mailtrap.

            Mail::to($user)->later($when, $email); // queue enfilera os emaails para que todos eles sejam mandados após o termino da requisição 
            // sleep(2); // adiciona um delay na execução do loop
        }
    }
}
