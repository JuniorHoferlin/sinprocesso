@extends('layouts.template')

@section('conteudo')
    <div class="documento_padrao lista panel panel-default">
        <div class="panel-body">
            <h1>Lista de Documentos Padrão</h1>
            <hr/>
            <form action="{{ route('documento_padrao.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="titulo">Titulo</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ request('titulo') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="descricao">Descrição</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ request('descricao') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="data">Data</label>
                            <input type="text" name="data" is="date" id="data" class="form-control mask-date" value="{{ request('data') }}"/>
                        </div>


                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('documento_padrao.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'documento_padrao.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('documento_padrao.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection