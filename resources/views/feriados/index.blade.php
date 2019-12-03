@extends('layouts.template')

@section('conteudo')
    <div class="lista panel panel-default">
        <div class="panel-body">
            <h1>Feriados</h1>
            <hr/>
            <form action="{{ route('feriados.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="data">Data</label>
                            <input type="text" name="data" id="date" is="date" class="form-control mask-date" value="{{ request('data') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="titulo">Título</label>
                            <input type="text" name="titulo" id="titulo" class="form-control" value="{{ request('titulo') }}"/>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="tipo" class="form-control">
                                <option value=""></option>
                                @foreach($tipos as $tipo)
                                    <option {{ request('tipo') == $tipo ? 'selected' : '' }} value="{{ $tipo }}">{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('feriados.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'feriados.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('feriados.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection