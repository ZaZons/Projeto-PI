@extends('template.layout')

@section('titulo', $filme->titulo)

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('filmes.index', ['page' => request()->get('page', 1)]) }}">Filmes</a></li>
        <li class="breadcrumb-item active">{{ $filme->titulo }}</li>
    </ol>
@endsection

@section('main')
    <div class="row mb-3">
        <div class="col-md-8">
            <h2>{{ $filme->titulo }}</h2>
            <p><strong>Género:</strong> {{ $filme->genero->nome }}</p>
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
        <div class="col-md-12">
            <h3>Sessões</h3>
            @if($sessoes->isEmpty())
                <p>Não há sessões futuras para este filme.</p>
            @else
                <table class="table">
                    <thead class="table-dark">
                    <tr>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Sala</th>
                        <th>Disponibilidade</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sessoes as $sessao)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}</td>
                            <td>{{ $sessao->sala->nome }}</td>
                            <td>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div>
                    {{ $sessoes->links() }}
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('filmes.index', ['page' => request()->get('page', 1)]) }}" class="btn btn-primary">Voltar</a>
        </div>
    </div>
    <br>
@endsection
