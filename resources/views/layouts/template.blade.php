<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ @config('sistema.titulo') }}</title>

    <link rel="icon" href="{{ asset('favicon.png') }}">

    @section('styles')
        <link href="{{ asset('css/libs/bootstrap.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/libs/font-awesome.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/tarefa.css') }}" rel="stylesheet"/>

        <link href="{{ asset('css/plugins/animate.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/plugins/bootstrap-datepicker.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/plugins/sweetalert.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/plugins/morris-0.5.0.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/plugins/select2.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/plugins/select2-bootstrap.min.css') }}" rel="stylesheet"/>
        <link href="{{ asset('css/plugins/toastr.min.css') }}" rel="stylesheet"/>

        <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    @show

    <script>var SITE_PATH = "{{  request()->root() }}";</script>
    <meta name="_token" content="{{ csrf_token() }}"/>
</head>

<body class="top-navigation">
<div id="wrapper">
    <div id="page-wrapper" class="gray-bg">

        <!-- Header -->
        <div class="row border-bottom white-bg">
            <nav class="navbar navbar-static-top" role="navigation">
                <div class="navbar-header">
                    <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse"
                            class="navbar-toggle collapsed" type="button">
                        <i class="fa fa-reorder"></i>
                    </button>
                    <span class="navbar-brand">
                        <i class="fa fa-folder-open-o"></i>
                        Sin-PROCESSO
                    </span>
                </div>
                @include('partials.menu')
            </nav>
        </div>
        <!-- Header[end] -->

        <!-- Contents -->
        <div class="wrapper wrapper-content">
            <div class="container">
                <div class="sk-spinner sk-spinner-wave loading-spinner">
                    <div class="sk-rect1"></div>
                    <div class="sk-rect2"></div>
                    <div class="sk-rect3"></div>
                    <div class="sk-rect4"></div>
                    <div class="sk-rect5"></div>
                </div>
                @include('flash::message')
                @yield('conteudo')
            </div>
        </div>
        <!-- Contents[end] -->
    </div>
</div>

<div class="modal fade" id="modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 25px;">
            <div style="text-align:center">
                <img src="{{ asset('img/loading.gif') }}" width="50" alt="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-xs">
    <div class="modal-dialog">
        <div class="modal-content" style="padding: 25px;">
            <div style="text-align:center">
                <img src="{{ asset('img/loading.gif') }}" width="50" alt="">
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script src="{{ asset('js/libs/jquery-2.1.1.js') }}"></script>
    <script src="{{ asset('js/libs/bootstrap.min.js') }}"></script>

    <script src="{{ asset('js/plugins/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap-datepicker-ptBR.min.js') }}"></script>
    <script src="{{ asset('js/plugins/toastr.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.mask.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery.money.js') }}"></script>
    <script src="{{ asset('js/plugins/validator.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-form.min.js') }}"></script>
    <script src="{{ asset('js/plugins/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2-ptBR.min.js') }}"></script>
    <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
    <script src="{{ asset('js/plugins/raphael-2.1.0.min.js') }}"></script>
    <script src="{{ asset('js/plugins/morris.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('js/libs/template.js') }}"></script>
    <script src="{{ asset('js/sistema/gepec.js') }}"></script>
@show

</body>
</html>
