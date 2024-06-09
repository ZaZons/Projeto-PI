@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="d-flex flex-start">
    <div class="mb-3 me-5 form-check">
        <input type="radio" class="form-check-input @error('tipo') is-invalid @enderror" name="tipo" id="inputTipoA"
               {{ $disabledStr }} {{ $funcionario->tipo == 'A' ? 'checked' : '' }} value="A">
        <label for="inputTipoA" class="form-check-label">Administrador</label>
        @error('tipo')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
    <div class="mb-3 form-check">
        <input type="radio" class="form-check-input @error('tipo') is-invalid @enderror" name="tipo" id="inputTipoF"
               {{ $disabledStr }} {{ $funcionario->tipo == 'F' ? 'checked' : '' }} value="F">
        <label for="inputTipoF" class="form-label">Funcionário</label>
        @error('tipo')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

<div class="mb-3 {{ !$showBloqueado ? 'd-none' : '' }}">
    <div class="form-check form-switch" {{ $disabledStr }}>
        <input type="hidden" name="bloqueado" value="0">
        <input type="checkbox" class="form-check-input @error('bloqueado') is-invalid @enderror" name="bloqueado"
               id="inputBloqueado" {{ $disabledStr }} {{ old('bloqueado', $funcionario->bloqueado) ? 'checked' : '' }} value="1">
        <label for="inputBloqueado" class="form-check-label">Bloqueado</label>
        @error('bloqueado')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

