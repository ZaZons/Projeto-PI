@extends('template.layout')

@section('main')

    @if($bilhete->estado == 'usado')
    <h2>Bilhete inválido</h2>

    @else
        <h3>Nome do cliente: {{$bilhete->cliente->user->name }}</h3>
        <img src="{{ $bilhete->cliente->user->fullPhotoUrl }}" alt="Foto do user">

        <br>
        <br>
        <form action="{{ route('bilhetes.update', ['bilhete' => $bilhete]) }}" method="post">
            @method('PUT')
            @csrf
            <button type="submit" class="btn btn-primary">Marcar como usado</button>
        </form>
    @endif
    <br>
    <br>

    <div class="col-md-6">
        <a href="{{ route('validarBilhetes.index', ['sessao' => $bilhete->sessao]) }}" class="btn btn-primary">Voltar</a>
    </div>
@endsection

