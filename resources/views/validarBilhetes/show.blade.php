@extends('template.layout')

@section('main')

    @if($bilhete->estado == 'usado')
    <h2>Bilhete inválido</h2>

    @else
        <h3>Nome do cliente: {{$bilhete->cliente->user->name }}</h3>
        <br>
        <img src="{{ $bilhete->cliente->user->foto_url }}" alt="Foto do user">

        <br>
            <a href="{{ route('bilhetes.update', ['bilhete' => $bilhete]) }}" class="btn btn-primary">Marcar como usado</a>
    @endif
    <br>
    <br>

    <div class="col-md-6">
        <a href="{{ route('validarBilhetes.index', ['sessao' => $bilhete->sessao]) }}" class="btn btn-primary">Voltar</a>
    </div>
@endsection

