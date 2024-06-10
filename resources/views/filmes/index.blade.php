@extends('template.layout')

@section('titulo', 'Filmes')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Filmes</li>
        <li class="breadcrumb-item active">Filmes</li>
    </ol>
@endsection

@section('main')
    <div class="mb-4">
        <form action="{{ route('filmes.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Procurar filmes..." value="{{ request('search') }}">
            <select name="genero" class="form-select me-2">
                <option value="">Todos os gêneros</option>
                @foreach($generos as $code => $nome)
                    <option value="{{ $code }}" {{ request('genero') == $code ? 'selected' : '' }}>{{ $nome }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>
    </div>

    <table class="table">
        <thead class="table-dark">
        <tr>
            <th>Título</th>
            <th>Género</th>
            <th>Ano</th>
            <th class="button-icon-col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($filmes as $filme)
            <tr>
                <td>{{ $filme->titulo }}</td>
                <td>{{ $filme->genero->nome }}</td>
                <td>{{ $filme->ano }}</td>
                <td class="button-icon-col">
                    <a class="btn btn-secondary"
                       href="{{ route('filmes.show', ['filme' => $filme, 'page' => request()->get('page', 1)]) }}">
                        <i class="fas fa-eye"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{ $filmes->appends(['search' => request('search'), 'genero' => request('genero')])->links() }}
    </div>
@endsection
