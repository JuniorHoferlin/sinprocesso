@extends('layouts.template')

@section('conteudo')
    <div class="Tipo_regra lista panel panel-default">
        <div class="panel-body">
            <h1>Insumos</h1>
            <hr/>
            <form action="{{ route('insumo.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="produto">Nome do insumo</label>
                            <input type="text" name="produto" id="produto" class="form-control" value="{{ request('produto') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="codigo_produto">Código do insumo</label>
                            <input type="text" name="codigo_produto" id="codigo_produto" class="form-control" value="{{ request('codigo_produto') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="especificacao">Especificação</label>
                            <input type="text" name="especificacao" id="especificacao" class="form-control" value="{{ request('especificacao') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="unidade">Unidade</label>
                            <input type="text" name="unidade" id="unidade" class="form-control" value="{{ request('unidade') }}"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('insumo.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'insumo.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('insumo.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection