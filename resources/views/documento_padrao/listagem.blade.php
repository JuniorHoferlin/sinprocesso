<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>Titulo</th>
        <th>Descrição</th>
        <th>Data</th>
        @if (!isset($imprimir))
            <th width="5%">Anexo</th>
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->titulo }}</td>
            <td>{{ $dado->descricao }}</td>
            <td>{{ formatarData($dado->data) }}</td>
            @if (!isset($imprimir))
                <td>
                    <a href="{{ url($dado->anexo) }}" target="_blank" class="btn btn-xs btn-default" title="Visualizar">
                        <i class="fa fa-external-link"></i>
                        Visualizar
                    </a>
                </td>
                @can('documento_padrao.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('documento_padrao.alterar', $dado->id)])
                    </td>
                @endcan
                @can('documento_padrao.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('documento_padrao.excluir', $dado->id)])
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