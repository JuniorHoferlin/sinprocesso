@extends('layouts.login')

@section('conteudo')
    <form action="{{ route('esqueci.post') }}" class="form" method="post">
        <div class="form-group text-left">
            <p><span class="small">* Email para receber o link para cadastrar uma nova senha.</span></p>
            <input type="text" name="email" class="form-control" placeholder="Email" autofocus="">
        </div>


        <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-12">
                <button type="submit" class="btn btn-primary btn-sm btn-block">Enviar</button>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12 text-left" style="margin-top: 5px;">
                <a href="{{ route('login') }}">
                    <small>Ir para o login</small>
                </a>
            </div>
        </div>

    </form>
@endsection