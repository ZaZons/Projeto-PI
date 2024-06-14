@extends('template.layout')

@section('titulo', $sessao->filme->titulo)

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('validarBilhetes.index', ['page' => request()->get('page', 1)]) }}">Sessões</a></li>
        <li class="breadcrumb-item active">{{ $sessao->filme->titulo }}</li>
    </ol>
@endsection

@section('main')
    <div class="row mb-3">
        <div class="col-md-8">
            <h3><strong>Sala:</strong> {{ $sessao->sala->nome }}</h3>
            <p><strong>Data:</strong> {{ $sessao->data }}</p>
            <p><strong>Hora:</strong> {{ $sessao->horario_inicio }}</p>
            <p><strong>Inserir id do bilhete:</strong></p>
            <!--<input type="number" name="id" class="form-control me-2" placeholder="Procurar bilhete" value="{{ $filterById }}"> -->
            <form action="{{ route('bilhetes.validar') }}" method="GET" class="d-flex">
                <input type="number" name="search" class="form-control me-2" placeholder="Procurar id de bilhete..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('sessoes.index', ['page' => request()->get('page', 1)]) }}" class="btn btn-primary">Voltar</a>
        </div>
    </div>
@endsection
