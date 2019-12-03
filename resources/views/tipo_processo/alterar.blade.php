@extends('layouts.template')

@section('conteudo')
    <div class="tipo_processo add panel panel-default navbar-default-new">
        <div class="panel-heading">
            <div class="panel-title m-b-md"><h2>Alterar tipo de processo</h2></div>
            <hr>
            <div class="panel-options">
                <ul class="nav nav-tabs">
                    <li class="{{ $aba == 'dados' ? 'active' : '' }}">
                        <a data-toggle="tab" href="#dados">
                            <i class="fa fa-info"></i> Dados
                        </a>
                    </li>
                    <li class="{{ $aba == 'regras' ? 'active' : '' }}">
                        <a data-toggle="tab" href="#regras">
                            <i class="fa fa-legal"></i> Regras
                        </a>
                    </li>
                    <li class="{{ $aba == 'tarefas' ? 'active' : '' }}">
                        <a data-toggle="tab" href="#tarefas">
                            <i class="fa fa-tasks"></i> Tarefas
                        </a>
                    </li>
                    <li class="{{ $aba == 'sequencia' ? 'active' : '' }}">
                        <a data-toggle="tab" href="#sequencia">
                            <i class="fa fa-sort-amount-desc"></i> Sequência
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="tab-content">
                <div id="dados" class="tab-pane {{ $aba == 'dados' ? 'active' : '' }}">
                    <form class="form-horizontal validate" method="post" role="form" action="{{ route('tipo_processo.alterar.post', $tipo->id) }}">
                        @include('partials.preenchimento_obrigatorio')
                        @include('tipo_processo.form', ['botao' => 'Salvar'])
                    </form>
                </div>
                <div id="regras" class="tab-pane {{ $aba == 'regras' ? 'active' : '' }}">
                    @include('tipo_processo.regras')
                </div>
                <div id="tarefas" class="tab-pane {{ $aba == 'tarefas' ? 'active' : '' }}">
                    @include('tipo_processo.tarefas')
                </div>
                <div id="sequencia" class="tab-pane {{ $aba == 'sequencia' ? 'active' : '' }}">
                    <div id="tab-4" class="tab-pane active">
                        <h2>Organize a sequência que as tarefas devem ser executadas</h2>
                        <hr>
                        <div id="sequencia-tarefa">
                            @include('tipo_processo.ordem')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection