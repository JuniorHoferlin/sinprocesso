@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/formularios.js') }}"></script>
@stop

@section('conteudo')
    <div class="formularios add panel panel-default navbar-default-new">
        <div class="panel-heading">
            <div class="panel-title m-b-md"><h2>Alterar formulário</h2></div>
            <hr>
            <div class="panel-options">
                <ul class="nav nav-tabs">
                    <li class="{{ $aba == 'dados' ? 'active' : '' }}">
                        <a data-toggle="tab" href="#dados">
                            <i class="fa fa-info"></i> Dados
                        </a>
                    </li>
                    <li class="{{ $aba == 'campos' ? 'active' : '' }}">
                        <a data-toggle="tab" href="#campos">
                            <i class="fa fa-list"></i> Campos
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="panel-body">
            <div class="tab-content">
                <div id="dados" class="tab-pane {{ $aba == 'dados' ? 'active' : '' }}">
                    <form class="form-horizontal validate" method="post" role="form" action="{{ route('formularios.alterar.post', $formulario->id) }}">
                        @include('partials.preenchimento_obrigatorio')
                        @include('formularios.form')
                    </form>
                </div>
                <div id="campos" class="tab-pane {{ $aba == 'campos' ? 'active' : '' }}">
                    @include('formularios.campos')
                </div>
            </div>
        </div>
    </div>
@endsection