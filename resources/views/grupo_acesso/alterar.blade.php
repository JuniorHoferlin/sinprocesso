@extends('layouts.template')

@section('conteudo')
    <div class="grupo_acesso add panel panel-default">
        <div class="panel-body">
            <h1>Alterar Grupos de Acesso</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('grupo_acesso.alterar.post', $grupo->id) }}">
                @include('partials.preenchimento_obrigatorio')
                @include('grupo_acesso.form')
            </form>
        </div>
    </div>
@endsection