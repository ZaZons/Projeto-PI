@php
    $disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="inputNome"
           {{ $disabledStr }} value="{{ old('name', $user->name) }}">
    <label for="inputNome" class="form-label">Nome</label>
    @error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3 form-floating">
    <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="inputEmail"
           {{ $disabledStr }} value="{{ old('email', $user->email) }}">
    <label for="inputEmail" class="form-label">Email</label>
    @error('email')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
    @enderror
</div>

<div class="mb-3">
    <div class="form-check form-switch" {{ $disabledStr }}>
        <input type="hidden" name="admin" value="0">
        <input type="checkbox" class="form-check-input @error('admin') is-invalid @enderror" name="admin"
               id="inputOpcional" {{ $disabledStr }} {{ old('admin', $user->admin) ? 'checked' : '' }} value="1">
        <label for="inputOpcional" class="form-check-label">Administrador</label>
        @error('admin')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>
