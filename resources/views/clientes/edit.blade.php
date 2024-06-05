@extends('template.layout')

@section('titulo', 'Editar perfil')

@section('subtitulo')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Página inicial</a></li>
        <li class="breadcrumb-item"><strong>{{ $cliente->user->name }}</strong></li>
        <li class="breadcrumb-item active">Perfil</li>
    </ol>
@endsection

@section('main')
    <form id="form_cliente" novalidate class="needs-validation" method="POST" enctype="multipart/form-data"
          action="{{ route('clientes.update', ['cliente' => $cliente]) }}">
        @csrf
        @method('PUT')
        <input type="hidden" name="id" value="{{ $cliente->id }}">
        <div class="d-flex flex-column flex-sm-row justify-content-start align-items-start">
            <div class="flex-grow-1 pe-2">
                @include('users.shared.fields', ['user' => $cliente->user, 'readonlyData' => false])
                @include('clientes.shared.fields', ['cliente' => $cliente, 'readonlyData' => false])
                <div class="my-1 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="ok" form="form_aluno">Guardar
                        Alterações
                    </button>
                    <a href="{{ route('alunos.show', ['aluno' => $cliente]) }}"
                       class="btn btn-secondary ms-3">Cancelar</a>
                </div>
            </div>
            <div class="ps-2 mt-5 mt-md-1 d-flex mx-auto flex-column align-items-center justify-content-between"
                 style="min-width:260px; max-width:260px;">
                @include('users.shared.fields_foto', [
                    'user' => $cliente->user,
                    'allowUpload' => true,
                    'allowDelete' => true,
                ])
            </div>
        </div>
    </form>
    @include('shared.confirmationDialog', [
        'title' => 'Quer realmente apagar a foto?',
         'msgLine1' => 'As alterações efetuadas ao dados do aluno vão ser perdidas!',
         'msgLine2' => 'Clique no botão "Apagar" para confirmar a operação.',
         'confirmationButton' => 'Apagar',
         'formActionRoute' => 'alunos.foto.destroy',
         'formActionRouteParameters' => ['aluno' => $cliente],
         'formMethod' => 'DELETE',
    ])
@endsection
