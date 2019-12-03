@extends('layouts.template')

@section('conteudo')
    <div class="documento_padrao add panel panel-default">
        <div class="panel-body">
            <h1>Cadastrar Documento Padrão</h1>
            <form class="form-horizontal validate" method="post" role="form" action="{{ route('documento_padrao.adicionar.post') }}" enctype="multipart/form-data">
                @include('partials.preenchimento_obrigatorio')
                @include('documento_padrao.form')
            </form>
        </div>
    </div>
@endsection