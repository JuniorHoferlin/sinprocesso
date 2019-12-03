@extends('layouts.template')

@section('conteudo')
    <div class="termo_referencia lista panel panel-default">
        <div class="panel-body">
            <h1>Lista de Termo de referência</h1>
            <hr/>
            <form action="{{ route('termo_referencia.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="codigo">TR</label>
                            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ request('codigo') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="diretoria">Diretoria</label>
                            <input type="text" name="diretoria" id="diretoria" class="form-control" value="{{ request('diretoria') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="fonte_recurso">Fonte de recurso</label>
                            <input type="text" name="fonte_recurso" id="fonte_recurso" class="form-control" value="{{ request('fonte_recurso') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="classificacao_orcamento">Classificação do orçamento</label>
                            <input type="text" name="classificacao_orcamento" id="classificacao_orcamento" class="form-control" value="{{ request('classificacao_orcamento') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="natureza_despesa">Natureza da despesa</label>
                            <input type="text" name="natureza_despesa" id="natureza_despesa" class="form-control" value="{{ request('natureza_despesa') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="bloco">Bloco</label>
                            <input type="text" name="bloco" id="bloco" class="form-control" value="{{ request('bloco') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="componente">Componente</label>
                            <input type="text" name="componente" id="componente" class="form-control" value="{{ request('componente') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="acao">Ação</label>
                            <input type="text" name="acao" id="acao" class="form-control" value="{{ request('acao') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="programa_ppa">Programa PPA</label>
                            <input type="text" name="programa_ppa" id="programa_ppa" class="form-control" value="{{ request('programa_ppa') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="ata_regristro_preco">Ata do registro de preço</label>
                            <input type="text" name="ata_regristro_preco" id="ata_regristro_preco" class="form-control" value="{{ request('ata_regristro_preco') }}"/>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('termo_referencia.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'termo_referencia.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('termo_referencia.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection