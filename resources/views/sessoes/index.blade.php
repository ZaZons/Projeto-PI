@extends('template.layout')

@section('titulo', 'Sessões')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Sessões</li>
        <li class="breadcrumb-item active">Sessões</li>
    </ol>
@endsection

@section('main')
    <div class="mb-4">
        <form action="{{ route('sessoes.index') }}" method="GET" class="form-floating">
            <div class="d-flex flex-grow-1 justify-content-between">
                <input type="date" class="form-control me-3" id="data" name="data" value="{{ old('data', $filterByData) }}">
                <input type="time" class="form-control me-3" id="horario" name="horario" value="{{ old('data', $filterByHorario) }}">
                <button type="submit" class="btn btn-primary">Pesquisar</button>
            </div>
            <div class="d-flex flex-grow-1 justify-content-end mt-2">
                <a href="{{ route('sessoes.index') }}" class="btn btn-danger">Limpar filtros</a>
            </div>
        </form>

    </div>
    @include('sessoes.shared.table', [
        'sessoes' => $sessoes,
    ])
    <div>
        {{ $sessoes->withQueryString()->links() }}
    </div>
@endsection
