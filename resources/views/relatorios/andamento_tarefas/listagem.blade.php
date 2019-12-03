<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th colspan="2">Processo</th>
        <th colspan="2">Tarefa</th>
        <th>Área</th>
        <th>Grupo</th>
        <th>Prazo Execução</th>
        <th>Duração</th>
    </tr>
    </thead>
    <tbody>
    @if (count($filtros))
        @forelse($dados as $dado)
            <tr>
                <td width="1">
                    <span class="label {{ encontraCorStatusProcessoRelatorio($dado->processo->status)  }}">
                        {{ $dado->processo->status }}
                    </span>
                </td>
                <td width="1">#{{ str_pad($dado->processo->id,4,'0',STR_PAD_LEFT) }}</td>
                <td width="1">
                    <span class="label {{ encontraCorStatusTarefaRelatorio($dado->ultimoHistorico->situacao)  }}">
                        {{ $dado->ultimoHistorico->situacao }}
                    </span>
                </td>
                <td>{{ "T{$dado->dados->identificador}" }} - {{ $dado->dados->descricao }}</td>
                <td>{{ $dado->dados->area->descricao }}</td>
                <td>{{ $dado->dados->grupoAcessoArea->dadosGrupo->descricao }}</td>
                <td>{{ $dado->dados->prazo_minutos }}min</td>
                <td>{{ segundosParaIntervalo($dado->duracao) }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="99">Nenhum registro encontrado.</td>
            </tr>
        @endforelse
    @else
        <tr>
            <td colspan="99">Clique em <strong>pesquisar</strong> para buscar os dados do relatório.</td>
        </tr>
    @endif
    </tbody>
</table>