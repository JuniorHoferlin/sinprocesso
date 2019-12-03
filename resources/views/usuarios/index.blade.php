@extends('layouts.template')

@section('conteudo')
    <div class="usuarios lista panel panel-default">
        <div class="panel-body">
            <h1>Lista de Usuários</h1>
            <hr/>
            <form action="{{ route('usuarios.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="nome">Nome</label>
                            <input type="text" name="nome" id="nome" class="form-control" value="{{ request('nome') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="cpf">CPF</label>
                            <input type="text" name="cpf" is="cpf" id="cpf" class="form-control" value="{{ request('cpf') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="form-control" value="{{ request('email') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="stauts">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value=""></option>
                                <option {{ request('status') == 'Ativo' ? 'selected' : '' }} value="Ativo">Ativo</option>
                                <option {{ request('status') == 'Inativo' ? 'selected' : '' }} value="Inativo">Inativo</option>
                            </select>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('usuarios.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'usuarios.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('usuarios.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection