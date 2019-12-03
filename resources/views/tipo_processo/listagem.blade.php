<table class="table table-hover table-bordered" width="100%">
    <thead>
    <tr style="background: #eee;">
        <th width="20%">Descrição</th>
        <th width="40%">Requisito</th>
        <th width="30%">Formulário</th>
        <th width="10%">Requer uma TR?</th>
        @if (!isset($imprimir))
            <th colspan="2" width="1%"></th>
        @endif
    </tr>
    </thead>
    <tbody>
    @forelse($dados as $dado)
        <tr>
            <td>{{ $dado->descricao }}</td>
            <td>{{ $dado->requesito }}</td>
            <td>{{ $dado->formulario->titulo }}</td>
            <td>{{ $dado->tr }}</td>
            @if (!isset($imprimir))
                @can('tipo_processo.alterar')
                    <td>
                        @include('partials.botao_editar', ['url' => route('tipo_processo.alterar', $dado->id)])
                    </td>
                @endcan
                @can('tipo_processo.excluir')
                    <td>
                        @include('partials.botao_excluir', ['url' => route('tipo_processo.excluir', $dado->id)])
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