@extends('layouts.template')

@section('conteudo')
    <div class="add panel panel-default">
        <div class="panel-body">
            <h1>Alterar Rota</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('feriados.alterar.post', $feriado->id) }}">
                @include('partials.preenchimento_obrigatorio')
                @include('feriados.form')
            </form>
        </div>
    </div>
@endsection