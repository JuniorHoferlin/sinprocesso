@extends('layouts.template')

@section('conteudo')
    <div class="lista panel panel-default">
        <div class="panel-body">
            <h1>Áreas</h1>
            <hr/>
            <form action="{{ route('areas.index') }}" method="get" class="form-filter">
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
                        @include('partials.botao_limpar', ['url' => route('areas.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'areas.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('areas.listagem')
            </div>
        </div>
    </div>
@endsection