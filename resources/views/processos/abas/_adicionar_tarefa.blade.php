<form class="form-horizontal validate" method="post" role="form" action="{{ route('processos.adicionar_tarefa_exclusiva.post') }}">
    <div class="panel-body">
        <div class="well">

            <div class="form-group">
                <label class="col-sm-2 control-label" for="id_tarefa_processo">
                    Tarefa
                    <small><i class="fa fa-asterisk"></i></small>
                </label>
                <div class="col-sm-6">
                    <select name="id_tarefa_processo" id="id_tarefa_processo" class="form-control" is="required">
                        <option></option>
                        @foreach($tarefas as $tarefa)
                            <option value="{{ $tarefa->id }}">T{{ $tarefa->dados->identificador }} - {{ $tarefa->dados->titulo }}</option>
                        @endforeach
                    </select>
                    <small>Escolha a tarefa relacionada a esta nova tarefa.</small>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="posicao">
                    Posição
                    <small><i class="fa fa-asterisk"></i></small>
                </label>
                <div class="col-sm-6">
                    <select name="posicao" id="posicao" class="form-control" is="required">
                        <option></option>
                        <option value="DEPOIS">Inserir depois</option>
                        <option value="DENTRO">Inserir dentro</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="iniciar">
                    Iniciar tarefa?
                    <small><i class="fa fa-asterisk"></i></small>
                </label>
                <div class="col-sm-6">
                    <select name="iniciar" id="iniciar" class="form-control" is="required">
                        <option></option>
                        <option value="S">Sim</option>
                        <option value="N">Não</option>
                    </select>
                </div>
            </div>

            @include('tarefas.form', ['tipo' => false])
        </div>
    </div>
</form>