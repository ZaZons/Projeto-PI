@extends('template.layout')

@section('titulo', 'Perfil')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">Gestão</li>
        <li class="breadcrumb-item"><a href="{{ route('funcionarios.index') }}">Funcionários</a></li>
        <li class="breadcrumb-item active">{{ $funcionario->name }}</li>
    </ol>
@endsection

@section('main')
    <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
        <div class="flex-grow-1 pe-2">
            @include('users.shared.fields', ['user' => $funcionario, 'readonlyData' => true])
            @include('funcionarios.shared.fields', ['funcionario' => $funcionario, 'readonlyData' => true, 'showBloqueado' => true])
            @if(Auth::user()->tipo === 'A')
                <div class="my-1 d-flex justify-content-end">
                    <button type="submit" name="delete" class="btn btn-danger" data-bs-toggle="modal"
                            data-bs-target="#confirmationModal">
                        Apagar conta
                    </button>
                    <a href="{{ route('funcionarios.edit', ['funcionario' => $funcionario]) }}" class="btn btn-secondary ms-3">
                        Editar perfil
                    </a>
                </div>
            @endif
        </div>
        <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
             style="min-width:260px; max-width:260px;">
            @include('users.shared.fields_foto', [
                'user' => $funcionario,
                'allowUpload' => false,
                'allowDelete' => false,
            ])
        </div>
    </div>

    @include('shared.confirmationDialog', [
    'title' => 'Quer realmente apagar a sua conta?',
     'msgLine1' => 'Os seus dados vão ser perdidos!',
     'msgLine2' => 'Clique no botão "Apagar" para confirmar a operação.',
     'confirmationButton' => 'Apagar',
     'formActionRoute' => 'funcionarios.destroy',
     'formActionRouteParameters' => ['funcionario' => $funcionario],
     'formMethod' => 'DELETE',
])
@endsection
m
