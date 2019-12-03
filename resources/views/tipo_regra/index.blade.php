@extends('layouts.template')

@section('conteudo')
    <div class="Tipo_regra lista panel panel-default">
        <div class="panel-body">
            <h1>Tipos de Regras</h1>
            <hr/>
            <form action="{{ route('tipo_regra.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="descricao">Título</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ request('descricao') }}"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('tipo_regra.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'tipo_regra.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('tipo_regra.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection