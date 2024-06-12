@extends('template.layout')
@section('titulo', 'Checkout')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Espaço Privado</li>
        <li class="breadcrumb-item">Carrinho</li>
        <li class="breadcrumb-item active">Checkout</li>
    </ol>
@endsection
@section('main')
    <form method="GET" action="{{ route('carrinho.pagamento') }}">
        <div class="mb-3 form-floating">
            <div class="mb-3 form-floating flex-grow-1">
                <input type="text" class="form-control" name="nif" id="inputNif"
                       value="{{ old('nif', $cliente->nif) }}">
                <label for="inputNif" class="form-label">Introduza o seu nº Contribuinte (opcional)</label>
            </div>

            <div class="mb-3 form-floating flex-grow-1">
                <select class="form-select @error('metodo') is-invalid @enderror" name="metodo" id="inputMetodo" required>
                    <option value="" disabled selected>Escolha o método de pagamento</option>
                    @if ($cliente->tipo_pagamento != null)
                        <option value="MetodoGuardado">Método guardado ({{ $cliente->tipo_pagamento }})</option>
                    @endif
                    <option value="VISA">Cartão Visa</option>
                    <option value="PAYPAL">PayPal</option>
                    <option value="MBWAY">MBWay</option>
                </select>
                <label for="inputMetodo" class="form-label">Método de pagamento</label>
            </div>
        </div>
        <div class="my-4 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                Seguinte
            </button>
            <a class="btn btn-danger ms-3" href="{{ route('carrinho.index') }}">Cancelar</a>
        </div>
    </form>
@endsection
