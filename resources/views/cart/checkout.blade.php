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
    <form id="formMetodo" method="GET" action="{{ route('carrinho.pagamento') }}">
        <div class="mb-3 form-floating">
            <select class="form-select @error('metodo') is-invalid @enderror" name="metodo" id="inputMetodo" required>
                <option value="" disabled selected>Escolha o método de pagamento</option>
                <option value="VISA">Cartão Visa</option>
                <option value="PAYPAL">PayPal</option>
                <option value="MBWAY">MBWay</option>
            </select>
            <label for="inputMetodo" class="form-label">Método de pagamento</label>
            @error('metodo')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </form>
    <div class="my-4 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary" form="formMetodo">
            Seguinte</button>
        <a class="btn btn-danger ms-3" href="{{ route('carrinho.index') }}">Cancelar</a>
    </div>
@endsection
