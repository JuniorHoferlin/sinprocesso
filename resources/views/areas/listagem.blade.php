<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th>
            Descrição
        </th>
        @if (!isset($imprimir))
            <th width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td style="padding-left:{{ ($dado['level'] * 20) + 10 }}px;">{{ $dado['text'] }}</td>
            @if (!isset($imprimir))
                @can('areas.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('areas.excluir', $dado['id'])])
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