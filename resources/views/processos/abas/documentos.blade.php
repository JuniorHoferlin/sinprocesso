@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/processos_documentos.js') }}"></script>
@stop

<h2>Documentos padrão</h2>
<hr>
<form action="{{ route('processos.salvar_documentos') }}" method="POST" name="salvar-documentos">
    <input type="hidden" name="id_processo" value="{{ $processo->id }}">
    <table class="table table-striped">
        <thead>
            <tr>
                @can('processos.salvar_documentos')
                    @if ($processo->aberto)
                        <th width="1"></th>
                    @endif
                @endcan
                <th>Titulo</th>
                <th>Descrição</th>
                <th width="150">Data</th>
                <th width="1" class="text-center">Anexo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documentos as $doc)
                <tr>
                    @can('processos.salvar_documentos')
                        @if($processo->aberto)
                            <td style="vertical-align: middle;">
                                <input type="checkbox" name="documentos[]" {{ in_array($doc->id, $processo->documentos->pluck('id')->toArray()) ? 'checked' : '' }} value="{{ $doc->id }}">
                            </td>
                        @endif
                    @endcan
                    <td style="vertical-align: middle;">{{ $doc->titulo }}</td>
                    <td style="vertical-align: middle;">{{ $doc->descricao }}</td>
                    <td style="vertical-align: middle;">{{ formatarData($doc->data) }}</td>
                    <td style="vertical-align: middle;">
                        <a href="{{ url($doc->anexo) }}" target="_blank" class="btn btn-xs btn-default" title="Visualizar">
                            <i class="fa fa-external-link"></i>
                            Visualizar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="99">Nenhum documento cadastrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @can('processos.salvar_documentos')
        @if ($processo->aberto && count($documentos))
            <hr>
            <p class="text-right m-t">
                <button type="submit" class="btn btn-primary">Salvar</button>
            </p>
        @endif
    @endcan
</form>