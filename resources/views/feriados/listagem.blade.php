<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>
            Data
        </th>
        <th>
            Título
        </th>
        <th>
            Tipo
        </th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ formatarData($dado->data) }}</td>
            <td>{{ $dado->titulo }}</td>
            <td>{{ $dado->tipo }}</td>
            @if (!isset($imprimir))
                @can('feriados.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('feriados.alterar', $dado->id)])
                    </td>
                @endcan

                @can('feriados.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('feriados.excluir', $dado->id)])
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