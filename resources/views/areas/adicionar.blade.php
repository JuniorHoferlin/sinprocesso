@extends('layouts.template')

@section('conteudo')
    <div class="add panel panel-default">
        <div class="panel-body">
            <h1>Cadastrar Áreas</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('areas.adicionar.post') }}">
                @include('partials.preenchimento_obrigatorio')
                @include('areas.form')
            </form>
        </div>
    </div>
@endsection