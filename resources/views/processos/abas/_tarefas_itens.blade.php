@if ($nivel == 1)
    <h2>
        Tarefas do processo

        @can('processos.enviar_sala_situacao')
            @if ($processo->permiteSalaSituacao() && $processo->aberto)
                <a href="{{ route('processos.enviar_sala_situacao') }}" class="btn btn-warning pull-right m-l marcar-sala-situacao"><i class="fa fa-share"></i>
                    <span>SALA DE SITUAÇÃO</span></a>
            @endif
        @endcan

        <a href="javascript:;" class="{{ $processo->estaEmSalaSituacao() ? '' : 'hide' }} btn btn-warning disabled pull-right m-l em-sala-situacao">EM SALA DE SITUAÇÃO</a>

        @can('processos.adicionar_tarefa_exclusiva')
            @if ($processo->aberto)
                <a href="{{ route('processos.adicionar_tarefa_exclusiva', $processo->id) }}" class="adicionar-tarefa btn btn-success pull-right"><i class="fa fa-plus-circle"></i>
                    <span>Adicionar tarefa</span></a>
            @endif
        @endcan

        <a href="javascript:;" class="atualizar-tarefas btn btn-success pull-right" style="margin-right: 10px;"><i class="fa fa-refresh"></i>
            <span>Atualizar</span></a>
    </h2>
    <hr>

    <div class="adicionar-tarefa-form"></div>
@endif

@if (count($tarefas) == 0 && count($processo->tarefas) > 0)
    <p>Nenhuma tarefa atribuida ao seu usuário.</p>
@else
    @forelse($tarefas as $tarefa)
        {{--<div class="well well-sm item-tarefa item-tarefa-situacao-{{ $tarefa->sala_situacao }}" style="margin-left: {{ ((50 * $nivel) - 50) }}px;">--}}
        <div class="well well-sm item-tarefa {{ $tarefa->status_array['class'] }}" style="margin-left: {{ ((50 * $nivel) - 50) }}px;">
            <table>
                <tbody>
                <tr>
                    <td rowspan="2" width="1" class="text-center col-1">{{ implode('.', $sequencial) }}</td>
                    <td colspan="2" class="col-2">
                        <div>
                            <h4>{{ $tarefa->dados->tipo != "PADRÃO" ? ( $tarefa->sala_situacao == "S" ? "({$tarefa->dados->tipo} EM SALA DE SITUAÇÃO)" : "({$tarefa->dados->tipo})" ) : "" }} T{{ $tarefa->dados->identificador }} - {{ $tarefa->dados->titulo }}</h4>
                            <h6>{{ $tarefa->dados->descricao }}</h6>
                            <h6>{{ $tarefa->dados->area->descricao }}</h6>
                        </div>
                    </td>
                    <td rowspan="2" width="1" class="col-4">
                        @can('tarefas.visualizar_documentos_processo')
                            <a href="{{ route('tarefas.visualizar_documentos_processo', $tarefa->id) }}" data-target="#modal" data-toggle="modal" class="btn btn-block btn-xs btn-default">Documentos</a>
                        @endcan

                        @can('tarefas.visualizar_observacoes_processo')
                            <a href="{{ route('tarefas.visualizar_observacoes_processo', $tarefa->id) }}" data-target="#modal" data-toggle="modal" class="btn btn-block btn-xs btn-default">Observações</a>
                        @endcan

                        @can('tarefas.visualizar_comentarios_processo')
                            <a href="{{ route('tarefas.visualizar_comentarios_processo', $tarefa->id) }}" data-target="#modal" data-toggle="modal" class="btn btn-block btn-xs btn-default">Comentários</a>
                        @endcan

                        @can('tarefas.visualizar_insumos_processo')
                            @if (count($tarefa->insumos))
                                <a href="{{ route('tarefas.visualizar_insumos_processo', $tarefa->id) }}" data-target="#modal" data-toggle="modal" class="btn btn-block btn-xs btn-default">Insumos</a>
                            @endif
                        @endcan
                    </td>
                    <td rowspan="2" class="col-5">
                        <div>
                            <span class="text-nowrap string-status">{{ $tarefa->status_array['status'] }}</span>
                            <span class="icon-status" data-id="{{ $tarefa->id }}" data-acao="{{ $tarefa->status_array['acao'] }}">
                                <i class="fa {{ $tarefa->status_array['icone'] }} fa-3x"></i>
                            </span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td width="1" class="text-nowrap col-3">
                        <h4>
                            <span style="font-weight: normal;">
                                Abertura:
                                @if ($tarefa->aberta)
                                    {{ $tarefa->usuarioAbertura->nome }}
                                    <span class="pull-right">{{ formatarData($tarefa->data_abertura, 'd/m/Y \à\s H\hi') }}</span>
                                @endif
                            </span>
                        </h4>
                    </td>
                    <td class="text-nowrap col-6">
                        <h4>
                            <span style="font-weight: normal;">
                                Fechamento:
                                @if ($tarefa->fechada)
                                    {{ formatarData($tarefa->data_finalizado, 'd/m/Y \à\s H\hi') }}
                                @endif
                            </span>
                        </h4>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        @if (count($tarefa->tarefasFilhas) > 0)
            <?php $sequencial[] = 1;?>
            @include('processos.abas._tarefas_itens', ['tarefas' => $tarefa->tarefasFilhas, 'nivel' => $nivel + 1, 'sequencial' => $sequencial])
        @endif

        @if($nivel == 1)
            <?php $sequencial = array($sequencial[$nivel - 1] + 1);?>
        @else
            <?php $sequencial[$nivel - 1] = $sequencial[$nivel - 1] + 1;?>
        @endif
    @empty
        <p>Nenhuma tarefa foi adicionada ao processo.</p>
    @endforelse
@endif