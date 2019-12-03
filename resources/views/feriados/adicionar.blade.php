@extends('layouts.template')

@section('conteudo')
    <div class="add panel panel-default">
        <div class="panel-body">
            <h1>Cadastrar Feriado</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('feriados.adicionar.post') }}">
                @include('partials.preenchimento_obrigatorio')
                @include('feriados.form')
            </form>
        </div>
    </div>
@endsection