<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$title}}</title>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('series.index') }}">Home</a>

        <a href="{{ route('logout') }}">Sair</a>
    </div>
</nav>

<div class="container">

    <h1>{{$title}}</h1>

    @isset($mensagemSucesso)
     <div class="alert alert-success">
        {{$mensagemSucesso}}
    </div>   
    @endisset


    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    {{$slot}}

</div>

</body>
</html>
