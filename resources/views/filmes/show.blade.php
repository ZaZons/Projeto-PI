@extends('template.layout')

@section('titulo', $filme->titulo)

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('filmes.index') }}">Filmes</a></li>
        <li class="breadcrumb-item active">{{ $filme->titulo }}</li>
    </ol>
@endsection

@section('main')
    <div class="row mb-3">
        <div class="col-md-8">
            <h2>{{ $filme->titulo }}</h2>
            <p><strong>Género:</strong> {{ $filme->genero_code }}</p>
            <p><strong>Ano:</strong> {{ $filme->ano }}</p>
            <p><strong>Sumário:</strong> {{ $filme->sumario }}</p>
            <p><strong>Trailer:</strong></p>
            <div class="embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src="{{ $filme->trailer_url }}" allowfullscreen></iframe>
            </div>
        </div>
        <div class="col-md-4">
            @if($filme->cartaz_url)
                <img src="{{ $filme->fullCartazUrl }}" alt="Cartaz de {{ $filme->titulo }}" class="img-fluid">
            @else
                <p>Cartaz não disponível</p>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('filmes.index') }}" class="btn btn-primary">Voltar</a>
        </div>
    </div>
@endsection
