@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/processos_planoacao.js') }}"></script>
@stop

<h2>Plano de ação</h2>
<hr>

@if (trim($planoAcao->descricao) == "" && $processo->aberto)
    <div id="plano-acao">
        <form action="{{ route('processos.salvar_plano_acao') }}" method="post" name="salvar-plano" class="validate">

            <div class="alert alert-warning">
                <h4>Atenção!</h4>
                <p>Depois de preenchido o plano de ação, não será mais possível editá-lo.</p>
            </div>

            <textarea name="descricao" id="plano_acao_descricao" is="required" class="form-control" rows="10">{{ $planoAcao->descricao }}</textarea>

            @can('processos.salvar_plano_acao')
                <p class="text-right m-t">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                </p>
                <input type="hidden" name="id_plano_acao" value="{{ $planoAcao->id }}">
            @endcan
        </form>
    </div>
@else
    <p class="text-right">Criado em {{ formatarData($planoAcao->updated_at, 'd/m/Y \à\s H:i') }}</p>
    <textarea disabled class="form-control" rows="10">{{ $planoAcao->descricao }}</textarea>
@endif