@extends('layouts.template')

@section('conteudo')
    <div class="Feriado lista panel panel-default">
        <div class="panel-body">
            <h1>Rotas</h1>
            <hr/>
            <form action="{{ route('rotas.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="descricao">Título</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ request('descricao') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_perm_tipo_rota">Tipo</label>
                            <select name="id_perm_tipo_rota" id="id_perm_tipo_rota" class="form-control">
                                <option value=""></option>
                                @foreach($tipos as $tipo)
                                    <option {{ request('id_perm_tipo_rota') == $tipo->id ? 'selected' : '' }} value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('rotas.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'rotas.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('rotas.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection