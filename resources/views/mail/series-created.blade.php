<x-mail::message>
# {{ $nomeSerie }} criada
 
A serie {{ $nomeSerie }} com {{ $qtdTemporadas }} temporadas e {{ $episodiosPorTemporada }} episodios por temporada foi criada.

Acesse aqui:
 
<x-mail::button :url="route('seasons.index', $idSerie)">
Ver Serie
</x-mail::button>
 
Thanks,<br>
{{ config('app.name') }}
</x-mail::message>