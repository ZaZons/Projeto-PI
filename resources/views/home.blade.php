@extends('template.layout')

@section('subtitulo')
    <p>Aplicação de Gestão Curricular, Recursos Humanos e Alunos</p>
@endsection

@section('main')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-light">Homepage</div>
                    <div class="card-body">
                        @auth
                            <p>{{ Auth::user()->name }}</p>
                        @else
                            <p>Bem vindo!</p>
                            <p>Podes fazer o login
                                <a href="{{ route('login') }}">aqui</a>.
                            </p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
