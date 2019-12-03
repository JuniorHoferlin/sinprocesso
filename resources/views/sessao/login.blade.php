@extends('layouts.login')

@section('conteudo')
    <form action="{{ route('login.post') }}" role="form" method="POST" class="formValidator">
        <div class="m-b">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                <input type="text" autofocus class="form-control" name="login" placeholder="Usuário" is="email" required>
            </div>
        </div>

        <div class="m-b">
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-unlock"></i></span>
                <input type="password" class="form-control" name="password" placeholder="Senha" is="required" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-12">
                <button type="submit" class="btn btn-primary btn-sm btn-block">Conectar</button>
            </div>

            <div class="col-md-6 text-left col-xs-12 col-sm-12 text-left" style="margin-top: 5px;">
                <a href="{{ route('esqueci') }}">
                    <small>Esqueceu sua senha?</small>
                </a>
            </div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
@endsection