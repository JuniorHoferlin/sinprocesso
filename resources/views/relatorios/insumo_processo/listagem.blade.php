<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th colspan="2">Processo</th>
        <th>Área</th>
        <th>Prazo para execução</th>
        <th>Inicio</th>
        <th>Tempo em execução</th>
        <th width="1">Insumos</th>
    </tr>
    </thead>
    <tbody>
    @if (count($filtros))
        @forelse($dados as $dado)
            <tr>
                <td width="1">
                    <span class="label {{ encontraCorStatusProcessoRelatorio($dado->status) }}">
                        {{ $dado->status }}
                    </span>
                </td>
                <td width="1">#{{ str_pad($dado->id,4,'0',STR_PAD_LEFT) }}</td>
                <td>{{ $dado->area->descricao }}</td>
                <td>{{ segundosParaIntervalo($dado->prazo) }}</td>
                <td>{{ formatarDataExtenso($dado->data_inicio) }}</td>
                <td>{{ segundosParaIntervalo($dado->tempo) }}</td>
                <td>
                    <a href="{{ route('insumo_processo.ver', $dado->id)  }}" data-target="#modal" data-toggle="modal" class="btn btn-xs btn-success">
                        Ver insumos
                    </a>
                </td>
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