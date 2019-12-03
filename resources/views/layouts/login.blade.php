<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ @config('sistema.titulo') }}</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}">

    <link href="{{ asset('css/libs/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/libs/font-awesome.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/plugins/animate.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>

    <script>var SITE_PATH = "{{  request()->root() }}";</script>
</head>

<body class="gray-bg" style="background: url('{{ asset('img/bg-green.jpg') }}') center top; padding-top: 150px;">

<div class="container">
    <div class="container">
        <div class="animated fadeInDown">
            <div class="row">
                <div class="col-md-4 col-md-offset-4 col-xs-12 col-sm-8 col-sm-offset-2 block-flat text-center">
                    <div class="row">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <h1><i class="fa fa-folder-open-o"></i> Sin-PROCESSO</h1>
                        </div>
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <p>Preencha os campos para se conectar no sistema.</p>
                        </div>

                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <div class="hr-line-dashed"></div>
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12 col-xs-12 col-sm-12">
                            @include('flash::message')
                            @yield('conteudo')
                        </div>
                        <div class="clearfix"></div>

                        <div class="col-md-12 col-xs-12 col-sm-12 m-t">
                            <div class="hr-line-dashed"></div>
                        </div>

                        <div class="col-xs-12">
                            <p class="m-t">
                                <small><strong>Infortech</strong> - Copyright © <?php echo date('Y') ?></small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/libs/jquery-2.1.1.js') }}"></script>
<script src="{{ asset('js/libs/bootstrap.min.js') }}"></script>
</body>
</html>
