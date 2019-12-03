@extends('layouts.template')

@section('conteudo')
    <div class="funcao lista panel panel-default">
        <div class="panel-body">
            <h1>Lista de Funções</h1>
            <hr/>
            <form action="{{ route('funcoes.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="descricao">Descrição</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ request('descricao') }}"/>
                        </div>


                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('funcoes.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'funcoes.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('funcoes.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection