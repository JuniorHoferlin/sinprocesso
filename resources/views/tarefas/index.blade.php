@extends('layouts.template')

@section('conteudo')
    <div class="tarefa lista panel panel-default">
        <div class="panel-body">
            <h1>Lista de Tarefas</h1>
            <hr/>
            <form action="{{ route('tarefas.index') }}" method="get" class="form-filter">
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
                            <label for="prazo_minutos">Prazo em dias</label>
                            <input type="text" name="prazo_minutos" id="prazo_minutos" class="form-control" value="{{ request('prazo_minutos') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="tuoi">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option></option>
                                @foreach($tipos as $tipo)
                                    <option {{ request('tipo') == $tipo ? 'selected' : '' }} value="{{ $tipo }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('tarefas.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'tarefas.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('tarefas.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection