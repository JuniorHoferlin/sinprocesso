@extends('layouts.template')

@section('conteudo')
    <div class="usuarios add panel panel-default">
        <div class="panel-body">
            <h1>Alterar Usuários</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('usuarios.alterar.post', $usuario->id) }}">
                @include('partials.preenchimento_obrigatorio')
                @include('usuarios.form')
            </form>
        </div>
    </div>
@endsection