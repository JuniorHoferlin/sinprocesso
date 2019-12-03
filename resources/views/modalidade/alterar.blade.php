@extends('layouts.template')

@section('conteudo')
    <div class="modalidade add panel panel-default">
        <div class="panel-body">
            <h1>Alterar Modalidade</h1>
            <hr>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('modalidade.alterar.post', $modalidade->id) }}">
                @include('partials.preenchimento_obrigatorio')
                @include('modalidade.form')
            </form>
        </div>
    </div>
@endsection