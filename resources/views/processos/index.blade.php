@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/selectareas.js') }}"></script>
@stop

@section('conteudo')
    <div class="lista panel panel-default">
        <div class="panel-body">
            <h1>Processos</h1>
            <hr/>
            <form action="{{ route('processos.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="descricao">Descrição</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ request('descricao') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_tipo_processo">Tipo</label>
                            <select name="id_tipo_processo" id="id_tipo_processo" class="form-control">
                                <option></option>
                                @foreach($tipos as $item)
                                    <option {{ request('id_tipo_processo') == $item->id ? 'selected': '' }} value="{{ $item->id }}">{{ $item->descricao }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-2 col-sm-6">
                            <label for="numero_cipar">N° CIPAR</label>
                            <input type="text" name="numero_cipar" id="numero_cipar" class="form-control" value="{{ request('numero_cipar') }}"/>
                        </div>

                        <div class="form-group col-lg-4 col-sm-6">
                            <label for="areas">Área</label>
                            <select name="id_area" id="areas" class="form-control" data-placeholder="Selecione a área..." data-areas="{{ json_encode($areas) }}">
                                <option></option>
                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-sm-6">
                            <label for="id_modalidade">Modalidade</label>
                            <select name="id_modalidade" id="id_modalidade" class="form-control">
                                <option></option>
                                @foreach($modalidades as $item)
                                    <option {{ request('id_modalidade') == $item->id ? 'selected': '' }} value="{{ $item->id }}">{{ $item->descricao }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-4 col-sm-6">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option></option>
                                @foreach($status as $item)
                                    <option {{ request('status') == $item ? 'selected': '' }} value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-2 col-sm-6">
                            <label for="data_inicio">Data de início</label>
                            <input type="text" name="data_inicio" id="data_inicio" class="form-control mask-date" is="date" value="{{ request('data_inicio') }}"/>
                        </div>

                        <div class="form-group col-lg-2 col-sm-6">
                            <label for="data_fim">Data de término</label>
                            <input type="text" name="data_fim" id="data_fim" class="form-control mask-date" is="date" value="{{ request('data_fim') }}"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('processos.index')])
                        @include('partials.botao_imprimir_relatorio')
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                <div class="project-list">
                    @include('processos.listagem')
                </div>
            </div>
        </div>
    </div>
@endsection