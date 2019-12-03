@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/processos.js') }}"></script>
@stop

@section('conteudo')
    <form class="form-horizontal validate" method="post" role="form" action="{{ route('processos.novo.post') }}" name="novo-processo">
        <input type="hidden" name="id_tipo_processo" value="{{ $tipo->id }}">
        @if (!is_null($tr))
            <input type="hidden" name="tr" value="{{ $tr }}">
        @endif
        <div class="processo add panel panel-default navbar-default-new">
            <div class="panel-heading">
                <div class="panel-title m-b-md">
                    <h1 style="padding-bottom: 10px;">
                        Abrir processo
                        <small class="text-info">
                            {{ $tipo->descricao }}
                        </small>
                    </h1>
                </div>
            </div>

            <div class="panel-body">
                @include('partials.preenchimento_obrigatorio')

                @if ($tipo->tr == 'S')
                    <div id="termo_referencia">
                        @include('processos.abas.termo_referencia')
                    </div>
                @endif

                @if (count($regras) > 0)
                    <div id="regras">
                        @if ($tipo->tr == 'S')
                            <br>
                        @endif

                        @include('processos.abas.regras')
                    </div>

                    <div id="detalhes" class="hide">
                        @include('processos.abas.detalhes')
                    </div>

                    <div id="formulario" class="hide">
                        @include('processos.abas.formulario')
                    </div>
                @else
                    <div id="detalhes">
                        @include('processos.abas.detalhes')
                    </div>

                    <div id="formulario">
                        @include('processos.abas.formulario')
                    </div>
                @endif
            </div>
        </div>

        <div class="text-right">
            <a href="#" class="btn btn-default" data-dismiss="modal">Cancelar</a>
            <button type="submit" class="btn btn-primary">Abrir processo</button>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
@endsection