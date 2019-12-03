@extends('layouts.template')

@section('conteudo')
    <div class="andamento-tarefa lista panel panel-default">
        <div class="panel-body">
            <h1>Relatório de Andamento de Tarefas</h1>
            <hr/>
            <form action="{{ route('andamento_tarefa.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="tarefa">Tarefa</label>
                            <input type="text" name="tarefa" id="tarefa" class="form-control" placeholder="Identificador ou título" value="{{ request('tarefa') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="processo">Processo</label>
                            <input type="text" name="processo" id="processo" class="form-control" placeholder="ID do processo ou descrição" value="{{ request('processo') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="status_p">Status do processo</label>
                            <select name="status_p" id="status_p" class="form-control">
                                <option></option>
                                @foreach($status_p as $item)
                                    <option {{ request('status_p') == $item ? 'selected': '' }} value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="status_t">Status da tarefa</label>
                            <select name="status_t" id="status_t" class="form-control">
                                <option></option>
                                @foreach($status_t as $item)
                                    <option {{ request('status_t') == $item ? 'selected': '' }} value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('andamento_tarefa.index')])
                        @include('partials.botao_imprimir_relatorio')
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('relatorios.andamento_tarefas.listagem')
                @if ($dados)
                    {{ $dados->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection