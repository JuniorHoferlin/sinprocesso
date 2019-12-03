@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/selectareas.js') }}"></script>
@stop

@section('conteudo')
    <div class="andamento-tarefa lista panel panel-default">
        <div class="panel-body">
            <h1>Relatório de processo por área</h1>
            <hr/>
            <form action="{{ route('informacao_area.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="processo">Processo</label>
                            <input type="text" name="processo" id="processo" class="form-control" placeholder="ID do processo ou descrição" value="{{ request('processo') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="status">Status do processo</label>
                            <select name="status" id="status" class="form-control">
                                <option></option>
                                @foreach($status as $item)
                                    <option {{ request('status') == $item ? 'selected': '' }} value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="area">Área</label>

                            <select name="area" id="areas" class="form-control" data-placeholder="Selecione a área..." data-areas="{{ json_encode($areas) }}">
                                <option></option>
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('informacao_area.index')])
                        @include('partials.botao_imprimir_relatorio')
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('relatorios.informacao_area.listagem')
                @if ($dados)
                    {{ $dados->appends(request()->query())->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection