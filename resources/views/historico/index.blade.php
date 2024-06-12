@extends('template.layout')

@section('titulo', 'Histórico')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Histórico</li>
        <li class="breadcrumb-item active">Histórico de Recibos</li>
    </ol>
@endsection

@section('main')
    <div class="mb-3">
        <form method="GET" action="{{ route('historico.index') }}">
            <div class="row">
                <div class="col-md-4">
                    <input type="date" name="data" class="form-control" value="{{ $filterByData }}">
                </div>
                @if(Auth::check() && Auth::user()->tipo === 'A' || Auth::user()-> tipo === 'F')
                    <div class="col-md-4">
                        <input type="text" name="searchNif" class="form-control me-2" placeholder="Procurar NIF..." value="{{ request('search') }}">
                    </div>
                @elseif(Auth::check() && Auth::user()->tipo === 'C')
                    <div class="col-md-4">
                        <input type="text" name="searchTPag" class="form-control me-2" placeholder="Procurar Forma de Pagamento..." value="{{ request('search') }}">
                    </div>
                @endif
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary">Pesquisar</button>
                </div>
            </div>
        </form>
    </div>

    <div>
        <table class="table">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Data</th>
                <th>Preço s/IVA</th>
                <th>IVA</th>
                <th>Preço c/IVA</th>
                <th>Nome</th>
                <th>Pagamento</th>
                <th>Referência</th>
                <th class="button-icon-col"></th>
                <th class="button-icon-col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($recibos as $recibo)
                <tr>
                    <td>{{$recibo->id}}</td>
                    <td>{{\Carbon\Carbon::parse($recibo->data)->format('d/m/Y') }}</td>
                    <td>{{ $recibo->preco_total_sem_iva }}€</td>
                    <td>{{ $recibo->iva }}€</td>
                    <td>{{ $recibo->preco_total_com_iva }}€</td>
                    <td>{{ $recibo->nome_cliente }}</td>
                    <td>{{ $recibo->tipo_pagamento }}</td>
                    <td>{{ $recibo->ref_pagamento }}</td>
                    <td class="button-icon-col">
                        <a class="btn btn-secondary"
                           href="{{ route('historico.show', ['historico' => $recibo->id, 'page' => request()->get('page', 1)]) }}">
                            <i class="fas fa-eye"></i>
                        </a>
                    </td>
                    <td class="button-icon-col">
                        <a class="btn btn-secondary"
                           href="{{ route('historico.show', ['historico' => $recibo->id, 'page' => request()->get('page', 1)]) }}">
                            <i class="fa-solid fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {{$recibos->links()}}
        </div>
    </div>
@endsection
