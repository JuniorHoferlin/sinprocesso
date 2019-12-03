<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>
            Descrição
        </th>
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
                @can('tipo_regra.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('tipo_regra.alterar', $dado->id)])
                    </td>
                @endcan
                @can('tipo_regra.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('tipo_regra.excluir', $dado->id)])
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