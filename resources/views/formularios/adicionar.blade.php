@extends('layouts.template')

@section('conteudo')
    <div class="formularios add panel panel-default navbar-default-new">
        <div class="panel-heading">
            <div class="panel-title m-b-md"><h2>Cadastrar novo formulário</h2></div>
            <hr>
            <div class="panel-options">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#dados">
                            <i class="fa fa-info"></i> Dados
                        </a>
                    </li>
                    <li class="disabled" style="padding-top: 13px;padding-left: 20px;">
                        <i class="fa fa-list"></i> Campos
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="tab-content">
                <div id="dados" class="tab-pane active">
                    <form class="form-horizontal validate" method="post" role="form" action="{{ route('formularios.adicionar.post') }}">
                        @include('partials.preenchimento_obrigatorio')
                        @include('formularios.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection