@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" id="inputNif"
               {{ $disabledStr }} value="{{ old('nif', $cliente->nif) }}">
        <label for="inputNif" class="form-label">Nº Contribuinte</label>
        @error('nif')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1 me-3">
        <select class="form-select @error('tipoPagamento') is-invalid @enderror" name="tipoPagamento" id="inputTipo" {{$disabledStr}}>
            <option {{ $cliente->tipo_pagamento == '' ? 'selected' : '' }} value="">Sem método guardado</option>
            <option {{ $cliente->tipo_pagamento == 'VISA' ? 'selected' : '' }} value="VISA">Visa</option>
            <option {{ $cliente->tipo_pagamento == 'PAYPAL' ? 'selected' : '' }} value="PAYPAL">PayPal</option>
            <option {{ $cliente->tipo_pagamento == 'MBWAY' ? 'selected' : '' }} value="MBWAY">MBWay</option>
        </select>
        <label for="inputTipo" class="form-label">Forma de pagamento</label>
        @error('tipoPagamento')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div><div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('refPagamento') is-invalid @enderror" name="refPagamento" id="inputRef"
               {{ $disabledStr }} value="{{ old('refPagamento', $cliente->ref_pagamento) }}">
        <label for="inputRef" class="form-label">Referência do pagamento</label>
        @error('refPagamento')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>


