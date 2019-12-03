@section('styles')
    @parent
    <link href="{{ asset('css/plugins/jasny/jasny-bootstrap.min.css') }}" rel="stylesheet"/>
@stop

@section('scripts')
    @parent
    <script src="{{ asset('js/plugins/jasny/jasny-bootstrap.min.js') }}"></script>
@stop

<div class="fileinput fileinput-new input-group" data-provides="fileinput">
    <div class="form-control" data-trigger="fileinput" style="overflow: auto">
        <span class="fileinput-filename">
            {{ isset($nomeArquivo) && !empty($nomeArquivo) ? $nomeArquivo : ''}}
        </span>
    </div>
    <span class="input-group-addon btn btn-default btn-file">
        <span class="fileinput-new">Selecionar arquivo</span>
        <span class="fileinput-exists">Alterar</span>
        <input type="file" name="{{ $nome }}" id="uid_{{ uniqid() }}" {{ isset($required) && $required ? 'is=required' : '' }}>
    </span>
    <a href="#" class="input-group-addon btn btn-default fileinput-exists" data-dismiss="fileinput">Remover</a>
</div>