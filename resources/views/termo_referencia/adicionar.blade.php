@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/termo_referencia.js') }}"></script>
@stop

@section('conteudo')
    <form class="validate" id="form-termo_referencia" method="post" role="form" action="{{ route('termo_referencia.adicionar.post') }}" enctype="multipart/form-data">
        <div class="termo_referencia add panel panel-default navbar-default-new">
            <div class="panel-heading">
                <div class="panel-title m-b-md">
                    <h1>Cadastrar Termo de referência</h1>
                </div>
                <hr>
                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="{{ $aba == 'detalhes' ? 'active' : '' }}">
                            <a data-toggle="tab" href="#detalhes">
                                Detalhes
                            </a>
                        </li>
                        <li class="{{ $aba == 'insumos' ? 'active' : '' }}">
                            <a data-toggle="tab" href="#insumos">
                                Insumos
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="panel-body">
                <div class="tab-content">
                    <div id="detalhes" class="tab-pane {{ $aba == 'detalhes' ? 'active' : '' }}">
                        @include('partials.preenchimento_obrigatorio')
                        @include('termo_referencia.form')
                        <div class="clearfix"></div>
                    </div>

                    <div id="insumos" class="tab-pane {{ $aba == 'insumos' ? 'active' : '' }}">
                        @include('termo_referencia.insumos')
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="text-right">
            <a href="{{ route('termo_referencia.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
            <input type="submit" form="form-termo_referencia" class="btn btn-primary" value="Salvar">
        </div>
    </form>
@endsection