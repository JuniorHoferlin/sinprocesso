@extends('layouts.template')

@section('conteudo')
    <div class="funcao add panel panel-default">
        <div class="panel-body">
            <h1>Cadastrar Funções</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('funcoes.adicionar.post') }}">
                @include('partials.preenchimento_obrigatorio')
                @include('funcoes.form')
            </form>
        </div>
    </div>
@endsection