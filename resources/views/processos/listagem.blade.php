<table class="table table-hover" width="100%">
    <thead>
    <tr>
        <th width="1">Status</th>
        <th>Cód.</th>
        <th>Detalhes</th>
        <th>Tipo/Área</th>
        <th>Tarefas</th>
        @if (!isset($imprimir))
            <th width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $processo)
        <tr>
            <td class="project-status">
                <span class="label label-{{ $processo->status_classe }}">{{ $processo->status }}</span>
            </td>
            <td width="1">
                <span style="font-size: 24px;">
                    {{ $processo->codigo }}
                </span>
            </td>
            <td class="project-title">
                <strong>
                    @if ($processo->bloqueado)
                        Processo bloqueado
                    @else
                        {{ $processo->descricao }}
                    @endif
                </strong>
                <br>
                <small class="text-nowrap">
                    Criado em
                    {{ formatarData($processo->data_inicio, 'd/m/Y \à\s H:i') }}
                </small>
                @if (!is_null($processo->data_fim))
                    <br>
                    <small class="text-nowrap">
                        Finalizado em
                        {{ formatarData($processo->data_fim) }}
                    </small>
                @endif
            </td>
            <td class="project-title">
                <strong class="text-nowrap">{{ $processo->tipo->descricao }}</strong>
                <br>
                <small class="text-nowrap">
                    {{ $processo->area->descricao }}
                </small>
            </td>
            <td class="project-completion">
                <small>Completado: {{ $processo->porcentagem_concluido }}%</small>
                <div class="progress progress-mini">
                    <div style="width: {{ $processo->porcentagem_concluido }}%;" class="progress-bar"></div>
                </div>
            </td>
            @if (!isset($imprimir))
                @can('processos.visualizar')
                    <td>
                        <a href="{{ route('processos.visualizar', $processo->id) }}" class="btn btn-white btn-sm">
                            <i class="fa fa-folder"></i> Visualizar
                        </a>
                    </td>
                @endcan
            @endif
        </tr>
    @empty
        <tr>
            <td colspan="99">Nenhum registro encontrado.</td>
        </tr>
    @endforelse
    </tbody>
</table>