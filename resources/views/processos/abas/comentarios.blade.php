@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/processos_comentarios.js') }}"></script>
@stop

<h2>Comentários</h2>
<hr>

@can('processos.adicionar_comentario')
    @if ($processo->aberto)
        <div class="well">
            <form action="{{ route('processos.adicionar_comentario') }}" method="post" class="validate" name="adicionar-comentario">
                <div class="form-group">
                    <label>Comentário</label>
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

<div class="comentarios-enviados">
    @include('processos.abas._comentario_itens')
</div>