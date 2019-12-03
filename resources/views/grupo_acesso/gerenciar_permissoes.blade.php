@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/gerenciar_permissoes.js') }}"></script>
@stop

@section('conteudo')
    <form action="{{ route('grupo_acesso.gerenciar_permissoes.post') }}" method="POST" class="form-filter" name="salvar-permissoes">
        <div class="bg-info p-xs b-r-sm">
            Não esqueça de clicar em <strong>Salvar</strong> no fim do formulário para persistir as alterações.
        </div>
        <br>
        <div class="lista panel panel-default">
            <div class="panel-body">
                <h1>Gerenciar Permissões</h1>
                <hr>
                <select name="id_grupo_acesso" id="id_grupo_acesso" class="form-control" is="required">
                    <option value=""></option>
                    @foreach($grupos as $grupo)
                        <option value="{{ $grupo->id }}">{{ $grupo->descricao }}</option>
                    @endforeach
                </select>
                <small>Escolha acima o grupo que deseja gerenciar as permissões.</small>
            </div>
        </div>

        <div class="row hide" id="carregando">
            <div class="col-lg-12">
                <p>Carregando...</p>
            </div>
        </div>

        <div class="row hide" id="listagem">
            @foreach($rotas as $tipo => $lista)
                <div class="col-lg-12">
                    <div class="ibox-content">
                        <h2>{{ $tipo }}</h2>
                        <small>
                            <a class="permitir-todos" href="javascript:void(0);"><i class="fa fa-check"></i> Permitir todos</a>
                        </small>
                        <ul class="todo-list m-t ui-sortable">
                            @foreach($lista as $permissao)
                                <li class="rota" style="cursor:pointer;">
                                    <div class="icheckbox_square-green" style="position: relative;">
                                        <input type="checkbox" name="rotas[]" value="{{ $permissao->id }}" id="rota-{{ $permissao->id }}" class="i-checks" style="position: absolute;">
                                    </div>
                                    <span style="margin-left: 25px;" class="m-l-xs">{{ $permissao->descricao }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
            <div class="col-lg-12">
                <div class="ibox-content">
                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-spin fa-spinner hide"></i> <span>Salvar</span>
                        </button>
                    </div>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                </div>
            </div>
        </div>
    </form>
@endsection