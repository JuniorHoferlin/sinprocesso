@extends('layouts.template')

@section('conteudo')
    <div class="formularios add panel panel-default navbar-default-new">
        <div class="panel-heading">
            <div class="panel-title m-b-md"><h2>Cadastrar tipo de processo</h2></div>
            <hr>
            <div class="panel-options">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#dados">
                            <i class="fa fa-info"></i> Dados
                        </a>
                    </li>
                    <li class="disabled">
                        <i class="fa fa-legal"></i> Regras
                    </li>
                    <li class="disabled">
                        <i class="fa fa-tasks"></i> Tarefas
                    </li>
                    <li class="disabled">
                        <i class="fa fa-sort-amount-desc"></i> Sequência
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="tab-content">
                <div id="dados" class="tab-pane active">
                    <form class="form-horizontal validate" method="post" role="form" action="{{ route('tipo_processo.adicionar.post') }}">
                        @include('partials.preenchimento_obrigatorio')
                        @include('tipo_processo.form', ['botao' => 'Continuar'])
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection