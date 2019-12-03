@extends('layouts.template')

@section('conteudo')
    <div class="Feriado add panel panel-default">
        <div class="panel-body">
            <h1>Cadastrar Rota</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('rotas.adicionar.post') }}">
                @include('partials.preenchimento_obrigatorio')
                @include('rotas.form')
            </form>
        </div>
    </div>
@endsection