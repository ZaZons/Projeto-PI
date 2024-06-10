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
        <form action="{{ route('sessoes.index') }}" method="GET" class="d-flex">
            <input type="date" id="start_date" name="start_date" class="form-control me-2" value="{{ request('start_date') }}" placeholder="Data Inicial">
            <input type="date" id="end_date" name="end_date" class="form-control me-2" value="{{ request('end_date') }}" placeholder="Data Final">
            <input type="text" name="search" class="form-control me-2" placeholder="Procurar sessões..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>
    </div>
    @include('sessoes.shared.table', [
        'sessoes' => $sessoes,
    ])
    <div>
        {{ $sessoes->appends(request()->query())->links() }} <!-- Aqui estamos mantendo os parâmetros de consulta -->
    </div>
@endsection
