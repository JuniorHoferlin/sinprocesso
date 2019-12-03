@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/carregacidades.js') }}"></script>
@stop

@section('styles')
    @parent
    <style>
        /* Pequeno hack para este select que tem opções muito grandes */
        .select2-selection__choice {
            float: none !important;
        }
    </style>
@stop

<div class="form-group">
    <label class="col-sm-2 control-label" for="nome">
        Nome
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="nome" id="nome" class="form-control" value="{{ isset($usuario) ? $usuario->nome : '' }}" placeholder="Nome" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="cpf">
        CPF
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="cpf" id="cpf" is="cpf" class="form-control" value="{{ isset($usuario) ? $usuario->cpf : '' }}" placeholder="CPF" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="matricula">
        Matrícula
    </label>
    <div class="col-sm-6">
        <input type="text" name="matricula" id="matricula" class="form-control" value="{{ isset($usuario) ? $usuario->matricula : '' }}" placeholder="Matrícula">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="email">
        Email
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="email" id="email" class="form-control" value="{{ isset($usuario) ? $usuario->email : '' }}" placeholder="Email" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="id_funcao_area">
        Função
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="id_funcao_area" id="id_funcao_area" required class="form-control">
            <option value=""></option>
            @foreach($funcaoAreas as $funcao)
                <option {{ isset($usuario) && $usuario->id_funcao_area == $funcao['id'] ? 'selected' : '' }} value="{{ $funcao['id'] }}">{{ $funcao['descricao'] }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="grupos">
        Grupos de Acesso
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <select name="grupos[]" id="grupos" required multiple class="form-control">
            <option></option>
            @foreach($gruposAcesso as $grupo)
                <option {{ isset($usuario) && in_array($grupo['id'], $usuario->gruposAcesso->pluck('id')->toArray()) == $grupo['id'] ? 'selected' : '' }} value="{{ $grupo['id'] }}">{{ $grupo['descricao'] }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="login">
        Login
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="text" name="login" id="login" class="form-control" value="{{ isset($usuario) ? $usuario->login : '&nbsp;' }}" placeholder="Login" required>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="senha">
        Senha
        <small><i class="fa fa-asterisk"></i></small>
    </label>
    <div class="col-sm-6">
        <input type="password" name="senha" id="senha" autocomplete="new-password" class="form-control" value="" placeholder="Senha" {{ !isset($usuario) ? 'required' : '' }}>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="id_estado">
        Estado
    </label>
    <div class="col-sm-6">
        <select name="id_estado" id="id_estado" class="carregacidades form-control">
            <option value=""></option>
            @foreach($estados as $estado)
                <option {{ isset($usuario) && !empty($usuario->id_cidade) && $usuario->cidade->id_estado == $estado->id ? 'selected' : '' }} value="{{ $estado->id }}">{{ $estado->descricao }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label" for="id_cidade">
        Cidade
    </label>
    <div class="col-sm-6">
        <select name="id_cidade" id="id_cidade" data-placeholder="Selecione o estado..." class="form-control">
            <option value=""></option>
            @if (isset($cidades))
                @foreach($cidades as $cidade)
                    <option {{ isset($usuario) && $usuario->id_cidade == $cidade->id ? 'selected' : '' }} value="{{ $cidade->id }}">{{ $cidade->descricao }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>


<div class="clearfix"></div>
<div class="text-right">
    <a href="{{ route('usuarios.index') }}" class="btn btn-default" data-dismiss="modal">Cancelar</a>
    <input type="submit" class="btn btn-primary" value="Salvar">
</div>
<input type="hidden" name="_token" value="{{ csrf_token() }}">