@extends('layouts.template')

@section('conteudo')
    <div class="tipo_processo lista panel panel-default">
        <div class="panel-body">
            <h1>Lista de Tipo de processo</h1>
            <hr/>
            <form action="{{ route('tipo_processo.index') }}" method="get" class="form-filter">
                <div class="well">
                    <div class="row">
                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="descricao">Descrição</label>
                            <input type="text" name="descricao" id="descricao" class="form-control" value="{{ request('descricao') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="requesito">Requesito</label>
                            <input type="text" name="requesito" id="requesito" class="form-control" value="{{ request('requesito') }}"/>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="id_formulario">Formulário</label>
                            <select name="id_formulario" id="id_formulario" class="form-control">
                                <option value=""></option>
                                @foreach($formularios as $form)
                                    <option {{ request('id_formulario') == $form->id ? 'selected' : '' }} value="{{ $form->id }}">{{ $form->titulo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-lg-3 col-sm-6">
                            <label for="tr">Requer uma TR?</label>
                            <select name="tr" id="tr" class="form-control">
                                <option value=""></option>
                                <option value="S">Sim</option>
                                <option value="N">Não</option>
                            </select>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="text-right">
                        @include('partials.botao_limpar', ['url' => route('tipo_processo.index')])
                        @include('partials.botao_imprimir_relatorio')
                        @include('partials.botao_novo', ['route' => 'tipo_processo.adicionar'])
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>

            <div class="table-responsive">
                @include('tipo_processo.listagem')
                {{ $dados->links() }}
            </div>
        </div>
    </div>
@endsection