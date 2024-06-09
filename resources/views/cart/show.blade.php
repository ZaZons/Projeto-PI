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
    <div>
        @dump(session('carrinho'))
        @for($i = 0; $i < 10; $i++)
            @php
                $sessao = "Sessao nº $i";
            @endphp
            <p>{{ $sessao }}</p>
            <td class="button-icon-col">
                <form method="POST" action="{{ route('carrinho.store', ['sessao' => $sessao]) }}">
                    @csrf
                    <button type="submit" name="addToCart" class="btn btn-success">
                        <i class="fa-solid fa-cart-plus"></i></button>
                </form>
            </td>
        @endfor

    </div>
    <div class="my-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" name="ok" form="formStore">
            Confirmar Sessões</button>
        <button type="submit" class="btn btn-danger ms-3" name="clear" form="formClear">
            Limpar Carrinho</button>
    </div>
    <form id="formStore" method="POST" action="" class="d-none">
        @csrf
    </form>
    <form id="formClear" method="POST" action="{{ route('carrinho.destroy', ['carrinho' => 'fds']) }}" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endsection
