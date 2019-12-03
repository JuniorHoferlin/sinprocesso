<table class="table table-striped">
    <thead>
    <tr>
        <th>Descrição</th>
        <th colspan="2">Adicionado em</th>
    </tr>
    </thead>
    <tbody>
    @foreach($observacoes as $observacao)
        <tr>
            <td>{{ $observacao->descricao }}</td>
            <td>{{ formatarData($observacao->created_at, 'd/m/Y \à\s H:i') }}</td>
            @can('processos.remover_observacao')
                <td width="1">
                    <a href="{{ route('processos.remover_observacao') }}" data-id="{{ $observacao->id }}" class="btn btn-danger btn-xs remover-observacao">
                        Remover
                    </a>
                </td>
            @endcan
        </tr>
    @endforeach
    <tr id="sem-observacoes" class="{{ count($observacoes) ? 'hide' : '' }}">
        <td colspan="99">Nenhuma observação enviada.</td>
    </tr>
    </tbody>
</table>