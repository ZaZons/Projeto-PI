@extends('template.layout')

@section('titulo', 'Perfil')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
        <li class="breadcrumb-item"><strong>{{ $cliente->user->name }}</strong></li>
        <li class="breadcrumb-item active">Perfil</li>
    </ol>
@endsection

@section('main')
    <div>
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @include('clientes.shared.fields', ['user' => $cliente->user, 'readonlyData' => true])
                <div class="my-1 d-flex justify-content-end">
                    <button type="submit" name="delete" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                        Apagar conta</button>
                    <a href="{{ route('clientes.edit', ['cliente' => $cliente]) }}" class="btn btn-secondary ms-3">
                        Editar perfil
                    </a>
                </div>
            </div>
            <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                 style="min-width:260px; max-width:260px;">
                @include('clientes.shared.fields_foto', [
                    'user' => $cliente->user,
                    'allowUpload' => false,
                    'allowDelete' => false,
                ])
            </div>
        </div>
    </div>

    @include('shared.confirmationDialog', [
    'title' => 'Quer realmente apagar a sua conta?',
     'msgLine1' => 'Os seus dados vão ser perdidos!',
     'msgLine2' => 'Clique no botão "Apagar" para confirmar a operação.',
     'confirmationButton' => 'Apagar',
     'formActionRoute' => 'clientes.destroy',
     'formActionRouteParameters' => ['cliente' => $cliente],
     'formMethod' => 'DELETE',
])
@endsection
m
