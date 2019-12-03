@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/processos_observacoes.js') }}"></script>
@stop

<h2>Observações</h2>
<hr>

@can('processos.adicionar_observacao')
    @if ($processo->aberto)
        <div class="well">
            <form action="{{ route('processos.adicionar_observacao') }}" method="post" class="validate" name="adicionar-observacao">
                <div class="form-group">
                    <label>Observação</label>
                    <textarea name="descricao" class="form-control" id="descricao" is="required" rows="3"></textarea>
                </div>
                <p class="text-right">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </p>
                <input type="hidden" name="id_processo" value="{{ $processo->id }}">
            </form>
        </div>
    @endif
@endcan

<div class="observacoes-enviadas">
    @include('processos.abas._observacao_itens')
</div>