@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

{{--TODO: field metodo de pagamento--}}
<div class="d-flex justify-content-between">
    <div class="mb-3 form-floating flex-grow-1">
        <input type="text" class="form-control @error('nif') is-invalid @enderror" name="nif" id="inputNif"
               {{ $disabledStr }} value="{{ old('nif', $funcionario->nif) }}">
        <label for="inputNif" class="form-label">Nº Contribuinte</label>
        @error('nif')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>


