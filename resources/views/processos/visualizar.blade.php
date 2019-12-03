@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/processos.js') }}"></script>
@stop

@section('conteudo')
    <div class="processo add panel panel-default navbar-default-new">
        <div class="panel-heading">
            <div class="panel-title m-b-md">
                <h1 style="padding-bottom: 10px;">
                    Gerenciar processo

                    @if ($processo->aberto)
                        <a href="javascript:;" class="btn btn-primary disabled pull-right m-l">PROCESSO ABERTO</a>
                    @else
                        <a href="javascript:;" class="btn btn-danger disabled pull-right m-l">PROCESSO {{ $processo->status }}</a>
                    @endif

                    <span class="text-danger pull-right">n° {{ $processo->codigo }}</span>
                </h1>

                <div id="progresso-processo">
                    @include('processos.abas._progresso_processo')
                </div>
            </div>
            <hr>
            <div class="panel-options">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#detalhes">
                            Detalhes
                        </a>
                    </li>

                    @if (!is_null($termo))
                        <li class="">
                            <a data-toggle="tab" href="#termo_referencia">
                                Termo de referência
                            </a>
                        </li>
                    @endif


                    @if (count($respostasFormulario))
                        <li class="">
                            <a data-toggle="tab" href="#formulario">
                                Formulário
                            </a>
                        </li>
                    @endif

                    @can('processos.visualizar_plano_acao')
                        <li class="">
                            <a data-toggle="tab" href="#plano_acao">
                                Plano de ação
                            </a>
                        </li>
                    @endcan

                    @can('processos.visualizar_tarefas')
                        <li class="">
                            <a data-toggle="tab" href="#tarefas">
                                Tarefas
                            </a>
                        </li>
                    @endcan

                    @can('processos.visualizar_documentos')
                        <li class="">
                            <a data-toggle="tab" href="#documentos">
                                Documentos
                            </a>
                        </li>
                    @endcan

                    @can('processos.visualizar_anexos')
                        <li class="">
                            <a data-toggle="tab" href="#anexos">
                                Anexos
                            </a>
                        </li>
                    @endcan

                    @can('processos.visualizar_observacoes')
                        <li class="">
                            <a data-toggle="tab" href="#observacoes">
                                Observações
                            </a>
                        </li>
                    @endcan

                    @can('processos.visualizar_comentarios')
                        <li class="">
                            <a data-toggle="tab" href="#comentarios">
                                Comentários
                            </a>
                        </li>
                    @endcan

                    @can('processos.visualizar_painel')
                        <li class="">
                            <a data-toggle="tab" href="#painel">
                                Painel
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="tab-content">
                <div id="detalhes" class="tab-pane active">
                    @include('processos.abas.detalhes_visualizar')
                    <div class="clearfix"></div>
                </div>

                @if (!is_null($termo))
                    <div id="termo_referencia" class="tab-pane">
                        @include('processos.abas.termo_referencia_visualizar')
                        <div class="clearfix"></div>
                    </div>
                @endif

                @if (count($respostasFormulario))
                    <div id="formulario" class="tab-pane">
                        @include('processos.abas.formulario_visualizar')
                        <div class="clearfix"></div>
                    </div>
                @endif

                @can('processos.visualizar_plano_acao')
                    <div id="plano_acao" class="tab-pane">
                        @include('processos.abas.plano_acao')
                        <div class="clearfix"></div>
                    </div>
                @endcan

                @can('processos.visualizar_documentos')
                    <div id="documentos" class="tab-pane">
                        @include('processos.abas.documentos')
                        <div class="clearfix"></div>
                    </div>
                @endcan

                @can('processos.visualizar_anexos')
                    <div id="anexos" class="tab-pane">
                        @include('processos.abas.anexos')
                        <div class="clearfix"></div>
                    </div>
                @endcan

                @can('processos.visualizar_observacoes')
                    <div id="observacoes" class="tab-pane">
                        @include('processos.abas.observacoes')
                        <div class="clearfix"></div>
                    </div>
                @endcan

                @can('processos.visualizar_comentarios')
                    <div id="comentarios" class="tab-pane">
                        @include('processos.abas.comentarios')
                        <div class="clearfix"></div>
                    </div>
                @endcan

                @can('processos.visualizar_tarefas')
                    <div id="tarefas" class="tab-pane">
                        @include('processos.abas.tarefas')
                        <div class="clearfix"></div>
                    </div>
                @endcan

                @can('processos.visualizar_painel')
                    <div id="painel" class="tab-pane">
                        @include('processos.abas.painel')
                        <div class="clearfix"></div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection