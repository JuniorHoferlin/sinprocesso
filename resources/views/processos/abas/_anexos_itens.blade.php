<table class="table table-striped">
    <thead>
    <tr>
        <th>Titulo</th>
        <th width="250">Adicionado em</th>
        <th width="150">Ações</th>
    </tr>
    </thead>

    <tbody>
    @foreach($anexos as $anexo)
        <tr>
            <td>{{ $anexo->titulo }}</td>
            <td>{{ formatarData($anexo->created_at, 'd/m/Y H\hi') }}</td>
            <td>
                @if ($anexo->anexo)
                    <a href="{{ url($anexo->anexo) }}" target="_blank" class="btn btn-default btn-xs">
                        Visualizar
                    </a>
                @endif

                @can('processos.remover_anexos')
                    <a href="{{ route('processos.remover_anexos') }}" class="btn btn-danger btn-xs remover-anexo" data-id="{{ $anexo->id }}">
                        Remover
                    </a>
                @endcan
            </td>
        </tr>
    @endforeach
    <tr id="sem-anexos" class="{{ count($anexos) ? 'hide' : '' }}">
        <td colspan="99">Nenhum anexo enviado.</td>
    </tr>
    </tbody>
</table>