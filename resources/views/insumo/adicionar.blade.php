@extends('layouts.template')

@section('conteudo')
    <div class="Insumo add panel panel-default">
        <div class="panel-body">
            <h1>Cadastrar Insumo</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('insumo.adicionar.post') }}">
                @include('partials.preenchimento_obrigatorio')
                @include('insumo.form')
            </form>
        </div>
    </div>
@endsection