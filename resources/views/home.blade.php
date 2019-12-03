@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/dashboard.js') }}"></script>
@stop

@section('conteudo')
    <form action="{{ route('home.buscar_dados_dashboard') }}">
        <div class="row">
            <div class="col-xs-12 col-sm-5 col-md-4 col-lg-3">
                <div class="form-group">
                    <div class="btn-group" data-toggle="buttons">                        
                        <label class="btn btn-default btn-outline active">
                            <input type="radio" name="selecao" value="mes" autocomplete="off" checked> Mês
                        </label>
                        <label class="btn btn-default btn-outline">
                            <input type="radio" name="selecao" value="semana" autocomplete="off"> Semana
                        </label>                        
                        <label class="btn btn-default btn-outline">
                            <input type="radio" name="selecao" value="dia" autocomplete="off"> Dia
                        </label>
                        <label class="btn btn-default btn-outline periodo">
                            <input type="radio" name="periodo" value="periodo" autocomplete="off"> Período
                        </label>
                    </div>
                </div>
            </div>
            <div id="datas" class="hide">
                <div class="col-xs-8 col-sm-5 col-md-5 col-lg-4">
                    <div class="input-group">
                        <input type="text" class="form-control mask-date" is="date" placeholder="Início" name="data-inicio"/>
                        <span class="input-group-addon">até</span>
                        <input type="text" class="form-control mask-date" is="date" placeholder="Fim" name="data-fim"/>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
                    <a href="javascript:void(0);" class="btn btn-primary buscar-por-periodo">Buscar</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <small id="periodo-datas"></small>
            </div>
        </div>
        <br>

        <div class="row">
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5> Processos</h5>
                        <span class="label label-success pull-right">
                    Total</span>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">
                            <i class="fa fa-folder-open"></i>
                            <span class="pull-right" id="TOTAL">
                                0
                            </span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5> Processos</h5>
                        <span class="label label-primary pull-right">
                    Finalizados</span>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">
                            <i class="fa fa-check"></i>
                            <span id="FINALIZADO" class="pull-right">
                                0
                            </span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5> Processos</h5>
                        <span class="label label-warning pull-right">
                    Em andamento</span>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">
                            <i class="fa fa-clock-o"></i>
                            <span class="pull-right" id="EM_ANDAMENTO">
                                0
                            </span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5> Processos</h5>
                        <span class="label label-danger pull-right">
                    bloqueados</span>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">
                            <i class="fa fa-lock"></i>
                            <span id="BLOQUEADO" class="pull-right">
                                0
                            </span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5> Insumos em trâmite</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="insumos-tramite">0</h1>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Tempo médio Tarefas</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins" id="tempo-medio-tarefas">00:00:00</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Modalidades</h5>
                        <small>&nbsp;Em aberto</small>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div id="flot-bar-chart" style="height: 300px"></div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection