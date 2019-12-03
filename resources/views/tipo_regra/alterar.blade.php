@extends('layouts.template')

@section('conteudo')
    <div class="Tipo_regra add panel panel-default">
        <div class="panel-body">
            <h1>Alterar Tipo de Regra</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('tipo_regra.alterar.post', $tipo->id) }}">
                @include('partials.preenchimento_obrigatorio')
                @include('tipo_regra.form')
            </form>
        </div>
    </div>
@endsection