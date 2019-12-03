@extends('layouts.template')

@section('conteudo')
    <div class="Feriado lista panel panel-default">
        <div class="panel-body">
            <h1>Tipos de Rotas</h1>
            <hr/>
            <form action="{{ route('tipos_rotas.index') }}" method="get" class="form-filter">
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
                        @include('partials.botao_limpar', ['url' => route('tipos_rotas.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'tipos_rotas.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('tipos_rotas.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection