@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/processos_anexos.js') }}"></script>
@stop

<h2>Anexos desse processo</h2>
<hr>

@can('processos.adicionar_anexos')
    @if ($processo->aberto)
        <div class="progress progress-striped active">
            <div id="anexo_progress_width" class="progress-bar progress-bar-success">
                <span id="anexo_progress_percent" class="sr-only">30% Complete (success)</span>
            </div>
        </div>
        <div class="well">
            <form action="{{ route('processos.adicionar_anexos') }}" method="post" class="validate" name="adicionar-anexo" enctype="multipart/form-data">
                <input type="hidden" name="id_processo" value="{{ $processo->id }}">
                <div class="row">
                    <div class="col-xs-6">
                        <label>Titulo</label>
                        <input type="text" name="titulo" class="form-control" is="required"/>
                    </div>
                    <div class="col-xs-4">
                        <label>Arquivo</label>
                        <input type="file" name="anexo" class="form-control" is="required"/>
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

<div id="anexos-enviados">
    @include('processos.abas._anexos_itens')
</div>
