@extends('template.layout')
@section('titulo', 'Checkout')
@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Espaço Privado</li>
        <li class="breadcrumb-item">Carrinho</li>
        <li class="breadcrumb-item">Checkout</li>
        <li class="breadcrumb-item active">Pagamento</li>
    </ol>
@endsection
@section('main')
    <form method="POST" action="{{ route('carrinho.pagar') }}">
        @csrf
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2 col-6">
                <div class="d-none"><input type="text" name="metodo" value="{{ $metodo }}"></div>
                @if($metodo == 'VISA')
                    <div class="mb-3 form-floating col-6">
                        <input type="text" class="form-control @error('number') is-invalid @enderror" name="number" id="inputNumber" value="{{ $usarGuardado ? $cliente->ref_pagamento : '' }}">
                        <label for="inputNumber" class="form-label">Número do cartão</label>
                        @error('number')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3 form-floating col-1">
                        <input type="text" class="form-control @error('cvc') is-invalid @enderror" name="cvc" id="inputCvc">
                        <label for="inputCvc" class="form-label">CVC</label>
                        @error('cvc')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endif
                @if($metodo == 'PAYPAL')
                    <div class="mb-3 form-floating col-6">
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail" value="{{ $usarGuardado ? $cliente->ref_pagamento : '' }}">
                        <label for="inputEmail" class="form-label">Email</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endif
                @error('pagamento')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
                @if($metodo == 'MBWAY')
                    <div class="mb-3 form-floating col-6">
                        <input type="text" class="form-control @error('telemovel') is-invalid @enderror" name="telemovel" id="inputTelemovel" value="{{ $usarGuardado ? $cliente->ref_pagamento : '' }}">
                        <label for="inputTelemovel" class="form-label">Número de telemóvel</label>
                        @error('telemovel')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                @endif
                <div class="mb-3 form-floating">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="guardarMetodo" id="guardarMetodo1">
                        <label class="form-check-label" for="guardarMetodo1">Guardar método de pagamento</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="my-4 d-flex justify-content-end col-6">
            <button type="submit" class="btn btn-primary">Pagar</button>
            <a class="btn btn-danger ms-3" href="{{ route('carrinho.index') }}">Cancelar</a>
        </div>
    </form>

    <div class="my-4 d-flex justify-content-end col-6">
    </div>
@endsection
