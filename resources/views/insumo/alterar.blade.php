@extends('layouts.template')

@section('conteudo')
    <div class="Insumo add panel panel-default">
        <div class="panel-body">
            <h1>Alterar Insumo</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('insumo.alterar.post', $insumo->id) }}">
                @include('partials.preenchimento_obrigatorio')
                @include('insumo.form')
            </form>
        </div>
    </div>
@endsection