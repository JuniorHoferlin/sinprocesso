@extends('layouts.template')

@section('conteudo')
    <div class="chamado_tecnico add panel panel-default">
        <div class="panel-body">
            <h1>Alterar Suporte</h1>
            <hr>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('suporte.alterar.post', $chamado_tecnico->id) }}">
                @include('partials.preenchimento_obrigatorio')
                @include('chamado_tecnico.form')
            </form>
        </div>
    </div>
@endsection