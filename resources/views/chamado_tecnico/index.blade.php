@extends('layouts.template')

@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/chamado.js') }}"></script>
@stop

@section('conteudo')
    <div class="ibox-content m-b-sm border-bottom">
        <div class="text-center p-lg">
            <h2>Você está tendo problemas com alguma coisa?</h2>

            @cannot('suporte.adicionar')
                <span>Você não tem autorização para abrir chamados.</span>
            @else
                <a class="btn btn-primary btn-sm" href="{{ route('suporte.adicionar') }}" data-toggle="modal" data-target="#modal-xs">
                    Abra um novo um chamado técnico
                </a>
            @endcannot
        </div>
    </div>

    <div class="chamados-enviados">
        @include('chamado_tecnico.listagem')
    </div>
@endsection