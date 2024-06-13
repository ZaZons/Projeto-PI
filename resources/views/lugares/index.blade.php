@php
    $bilheteJaExistente = false;
    $titulo = $sessao->filme->titulo;
    $carrinho = session('carrinho');
    $lugares = $sessao->sala->lugares;
@endphp
@extends('template.layout')

@section('titulo', "Escolha de lugares - $titulo")
@section('main')
<h4>Bilhete nº {{$nBilhete}}</h4>
    <div class="d-flex justify-content-center">
        <div>
            @foreach($lugares as $lugar)
                @php($thisLugar = $lugar->id)
                @if($lugar->posicao == 1)
                    <br>
                @endif

                @foreach($sessao->bilhetes as $bilhetesExistentes)
                    @if ($bilhetesExistentes->lugar == $lugar)
                        @php($bilheteJaExistente = true)
                    @endif
                @endforeach

                @foreach($carrinho as $bilheteNoCarrinho)
                    @if ($bilheteNoCarrinho->lugar_id == $lugar->id && $bilheteNoCarrinho->sessao_id == $sessao->id)
                        @php($bilheteJaExistente = true)
                    @endif
                @endforeach

                @if($bilheteJaExistente)
                    <a><i class="fas fa-couch me-2 mt-4" style="color: red"></i></a>
                @else
                    <a href="{{ route('carrinho.lugares', ['sessao' => $sessao, 'lugar' => $lugar, 'nBilhete' => $nBilhete, 'quantidade' => $quantidade]) }}"><i class="fas fa-couch me-2 mt-4"></i></a>
                @endif
                @php($bilheteJaExistente = false)
            @endforeach
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        <h3>Ecrã</h3>
    </div>
@endsection
