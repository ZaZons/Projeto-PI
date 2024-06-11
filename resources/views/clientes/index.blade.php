@extends('template.layout')

@section('titulo', 'Clientes')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item active">Clientes</li>
    </ol>
@endsection

@section('main')
    <form method="GET" action="{{ route('clientes.index') }}">
        <div class="d-flex justify-content-between">
            <div class="pe-2 col-6 justify-content-between">
                <div class="d-flex">
                    <div class="mb-3 me-2 flex-grow-1 form-floating">
                        <input type="text" class="form-control" name="nome" id="inputNome"
                               value="{{ old('nome', $filterByNome) }}">
                        <label for="inputNome" class="form-label">Nome</label>
                    </div>
                <div>
                    <button type="submit" class="btn btn-primary mb-3" name="filtrar">Filtrar</button>
                </div>
                </div>
            </div>
        </div>
    </form>
    @include('clientes.shared.table', [
        'clientes' => $clientes,
    ])
    <div>
        {{ $clientes->withQueryString()->links() }}
    </div>
@endsection
