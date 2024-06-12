@extends('template.layout')
@section('titulo', 'Carrinho')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Espaço Privado</li>
        <li class="breadcrumb-item active">Carrinho</li>
    </ol>
@endsection
@section('main')
    <div>
        <h3>Sessões no carrinho</h3>
    </div>
    @if($carrinho)
        <div>
            @include('bilhetes.shared.table', ['sessoes' => $carrinho, 'precoSemIva' => $config->preco_bilhete_sem_iva, 'iva' => $config->percentagem_iva])
        </div>
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" form="formStore">
                Confirmar Sessões</button>
            <button type="submit" class="btn btn-danger ms-3" name="clear" form="formClear">
                Limpar Carrinho</button>
        </div>

        <form id="formStore" method="GET" action="{{ route('carrinho.checkout') }}" class="d-none">
        </form>
        <form id="formClear" method="POST" action="{{ route('carrinho.clear') }}" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @else
        <div>
            O seu carrinho está vazio
        </div>
    @endif
@endsection
