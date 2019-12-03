<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>Descrição</th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->descricao }}</td>
            @if (!isset($imprimir))
                @can('modalidade.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('modalidade.alterar', $dado->id)])
                    </td>
                @endcan
                @can('modalidade.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('modalidade.excluir', $dado->id)])
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