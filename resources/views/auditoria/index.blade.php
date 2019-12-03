@extends('layouts.template')

@section('conteudo')
    <div class="lista panel panel-default">
        <div class="panel-body">
            <h1>Auditoria</h1>
            <hr/>
            <form action="{{ route('auditoria.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_perm_tipo_rota">Módulo</label>
                            <select name="id_perm_tipo_rota" id="id_perm_tipo_rota" class="form-control">
                                <option></option>
                                @foreach($tipos as $tipo)
                                    <option {{ request('id_perm_tipo_rota') == $tipo->id ? 'selected' : '' }} value="{{ $tipo->id }}">{{ $tipo->descricao }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_usuario">Usuário</label>
                            <select name="id_usuario" id="id_usuario" class="form-control">
                                <option></option>
                                @foreach($usuarios as $usuario)
                                    <option {{ request('id_usuario') == $usuario->id ? 'selected' : '' }} value="{{ $usuario->id }}">{{ $usuario->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="data">Data</label>
                            <input type="text" name="data" id="data" class="form-control mask-date" is="date" value="{{ request('data') }}"/>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('auditoria.index')])
                        @include('partials.botao_imprimir_relatorio')
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('auditoria.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection