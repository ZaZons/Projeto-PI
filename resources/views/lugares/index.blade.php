@extends('template.layout')

@section('titulo', 'Escolha de lugares')

@section('main')
    <div>
        @foreach($lugares as $lugar)
            @if($lugar->posicao == 1)
                <br>
            @endif

            @foreach($sessao->bilhetes as $bilhetesExistentes)
                @if ($bilhetesExistentes->lugar == $lugar)
                    @php($bilheteJaExistente = true)
                @endif
            @endforeach

            @if($bilheteJaExistente)
                <button type="submit" class="btn btn-link" disabled><i class="fas fa-couch" style="color: red"></i></button>
            @else
                <form action="{{ route('carrinho.lugares', ['sessao' => $sessao, 'lugar' => $lugar]) }}" method="post" class="d-none" id="formLugares">
                    @csrf
                    @method('PUT')
                </form>
                <button type="submit" class="btn btn-link" form="formLugares"><i class="fas fa-couch"></i></button>
            @endif
            @php($bilheteJaExistente = false)
        @endforeach
    </div>
@endsection
