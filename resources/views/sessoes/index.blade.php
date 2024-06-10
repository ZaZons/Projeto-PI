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
            <input type="text" name="filme" class="form-control me-2" placeholder="Procurar sessões por filme..." value="{{ old('filme', $filterByFilme) }}">
            <button type="submit" class="btn btn-primary">Pesquisar</button>
        </form>

    </div>

    <table class="table">
        <thead class="table-dark">
        <tr>
            <th>Filme</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Sala</th>
            <th>Lugares Disponíveis</th>
            <th class="button-icon-col"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($sessoes as $sessao)
            <tr>
                <td>{{ $sessao->filme->titulo }}</td>
                <td>{{ \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}</td>
                <td>{{ $sessao->sala->nome }}</td>
                <td>
                    {{ $sessao->lugares_nao_usados->count() }}
                </td>
                <td class="button-icon-col">
                    <a class="btn btn-secondary" href="#">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div>
        {{ $sessoes->appends(request()->query())->links() }} <!-- Aqui estamos mantendo os parâmetros de consulta -->
    </div>
@endsection
