<h2>Tarefa T{{ $tarefa->dados->identificador }} - Documentos</h2>
<hr>

@can('tarefas.adicionar_documento')
    @if ($tarefa->status == 'PENDENTE' && $tarefa->status_array['acao'] != 'semPermissao')
        <div class="progress progress-striped active">
            <div id="documento_tarefa_progress_width" class="progress-bar progress-bar-success">
                <span id="documento_tarefa_progress_percent" class="sr-only">30% Complete (success)</span>
            </div>
        </div>

        <div class="well">
            <form action="{{ route('tarefas.adicionar_documento') }}" method="post" class="validate" name="adicionar-documento-tarefa" enctype="multipart/form-data">
                <input type="hidden" name="id_tarefa_processo" value="{{ $tarefa->id }}">
                <div class="row">
                    <div class="col-xs-6">
                        <label>Titulo</label>
                        <input type="text" name="titulo" class="form-control" required/>
                    </div>
                    <div class="col-xs-4">
                        <label>Arquivo</label>
                        <input type="file" name="anexo" class="form-control" required/>
                    </div>
                    <div class="col-xs-2">
                        <label>&nbsp;</label> <br>
                        <input type="submit" class="btn btn-block btn-primary" value="Anexar"/>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="alert alert-warning m-t" style="margin-bottom: 0px">
                    <h4>Tipo de arquivo permitido</h4>
                    <p>Tamanho máximo: 5mb</p>
                    <p>Extensões permitidas: PDF, JPG, PNG, GIF, ZIP, RAR, DOC, DOCX, PPT, PPS, PPTX, TXT, XLS, XLSX, ODT, ODS, ODP, MP3, MP4, WMV, RMVB, AVI</p>
                </div>
            </form>
        </div>
    @endif
@endcan

<div id="documentos-tarefa">
    @include('processos.abas._tarefas_documentos_itens', ['tarefa' => $tarefa])
</div>