<div class="row">
    <div class="col-lg-3">
        <div class="widget style1 gray-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-calendar-o fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Início</span>
                    <h2 class="font-bold">
                        {{ formatarData($processo->data_inicio, 'd/m/y') }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="widget style1 gray-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-list fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Dias em execução</span>
                    <h2 class="font-bold">
                        {{ $processo->dias_execucao }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="widget style1 gray-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa fa-clock-o fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Prazo em dias</span>
                    <h2 class="font-bold">
                        {{ $processo->prazo_dias }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="widget style1 gray-bg">
            <div class="row">
                <div class="col-xs-4">
                    <i class="fa {{ $processo->prazo_situacao['icone'] }} fa-5x"></i>
                </div>
                <div class="col-xs-8 text-right">
                    <span> Situação</span>
                    <h2 class="font-bold">
                        {{ $processo->prazo_situacao['situacao'] }}
                    </h2>
                </div>
            </div>
        </div>
    </div>
</div>

<table class="table table-striped">
    <thead>
    <tr>
        <th></th>
        <th>Tarefa</th>
        <th>Abertura</th>
        <th>Fechamento</th>
        <th style="text-align: center;">Dias em execução</th>
        <th style="text-align: center;">Prazo (dias)</th>
        <th style="text-align: center;">Situação Prazo</th>
    </tr>
    </thead>
    <tbody>
    @include('processos.abas._painel_itens_tarefas', ['nivel' => 1, 'sequencial' => [1]])
    </tbody>
</table>