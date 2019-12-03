@extends('layouts.template')

@section('conteudo')
    <div class="grupo_acesso add panel panel-default">
        <div class="panel-body">
            <h1>Cadastrar Grupos de Acesso</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('grupo_acesso.adicionar.post') }}">
                @include('partials.preenchimento_obrigatorio')
                @include('grupo_acesso.form')
            </form>
        </div>
    </div>
@endsection