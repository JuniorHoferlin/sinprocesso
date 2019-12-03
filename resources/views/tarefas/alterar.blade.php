@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/tarefas.js') }}"></script>
@stop

@section('conteudo')
    <div class="tarefa add panel panel-default navbar-default-new">
        <div class="panel-heading">
            <div class="panel-title m-b-md"><h2>Alterar Tarefa</h2></div>
            <hr>
            <div class="panel-options">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#dependencias">
                            <i class="fa fa-level-down"></i> Dependências
                        </a>
                    </li>
                    <li class="">
                        <a data-toggle="tab" href="#formulario">
                            <i class="fa fa-info"></i>Detalhes
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <form class="form-horizontal validate" method="post" role="form" action="{{ route('tarefas.alterar.post', $tarefa->id) }}">
            <div class="panel-body">
                <div class="tab-content">
                    <div id="dependencias" class="tab-pane active">
                        @include('tarefas.dependencias')
                        <br>
                        <div class="clearfix"></div>
                        <div class="text-right">
                            <a href="{{ route('tarefas.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                            <input type="submit" class="btn btn-primary" value="Salvar">
                        </div>
                    </div>
                    <div id="formulario" class="tab-pane">
                        @include('partials.preenchimento_obrigatorio')
                        @include('tarefas.form')
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection