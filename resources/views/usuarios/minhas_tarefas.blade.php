@extends('layouts.template')
@section('conteudo')
    <div class="lista panel panel-default">
        <div class="panel-body">
            <h1>Minhas tarefas</h1>
            <hr/>
            <div class="table-responsive">
                <div class="project-list">
                    @include('processos.listagem')
                </div>
            </div>
        </div>
    </div>
@endsection