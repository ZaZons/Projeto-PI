@extends('template.layout')

@section('titulo', 'Recibos')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('historico.index', ['page' => request()->get('page', 1)]) }}">Recibos</a></li>
        <li class="breadcrumb-item active">{{ 'Bilhetes' }}</li>
    </ol>
@endsection

@section('main')
    <div>
        <table class="table">
            <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Filme</th>
                <th>Sala</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Lugar</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($recibo->bilhetes as $bilhete)
                @php
                    $sessao = $bilhete->sessao;
                    $filme = $sessao->filme;
                    $sala = $sessao->sala;
                    $lugar = $bilhete->lugar;
                    $lugarDescricao = $lugar ? $lugar->fila . $lugar->posicao : 'N/A';
                @endphp
                <tr>
                    <td>{{ $bilhete->id }}</td>
                    <td>{{ $filme->titulo }}</td>
                    <td>{{ $sala->nome }}</td>
                    <td>{{ \Carbon\Carbon::parse($sessao->data)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($sessao->horario_inicio)->format('H:i') }}</td>
                    <td>{{ $lugarDescricao }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-6">
            <a href="{{ route('historico.index', ['page' => request()->get('page', 1)]) }}" class="btn btn-primary">Voltar</a>
        </div>
    </div>
    <br>
@endsection
