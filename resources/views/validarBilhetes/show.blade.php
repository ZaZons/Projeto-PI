@extends('template.layout')

@section('main')

    @if($bilhete->estado == 'usado')
    <h2>Bilhete inválido</h2>

    @else
        <h3>Nome do cliente: {{$bilhete->cliente->user->name }}</h3>
        <br>
        <img src="{{ $bilhete->cliente->user->foto_url }}" alt="Foto do user">

        <div class="col-md-6">
            <a href="{{ route('validarBilhetes.index', ['page' => request()->get('page', 1)]) }}" class="btn btn-primary">foda se</a>
        </div>
        <br>
            <a href="{{ route('/update', ['id' => $id]) }}" class="btn btn-primary">Marcar como usado</a>

        </form>
    @endif
    <br>

    <div class="col-md-6">
        <a href="{{ route('validarBilhetes.index', ['sessao' => $sessao]) }}" class="btn btn-primary">Voltar</a>
    </div>
@endsection

