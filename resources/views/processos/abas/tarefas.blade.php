@section('scripts')
    @parent
    <script src="{{ asset('js/sistema/processos_tarefas.js') }}"></script>
    {{--Scripts para form de adicionar tarefa--}}
    <script src="{{ asset('js/sistema/selectareas.js') }}"></script>
    <script src="{{ asset('js/sistema/carregagrupoacesso.js') }}"></script>
@stop

<div id="tarefas-processo">
    @include('processos.abas._tarefas_itens', ['nivel' => 1, 'sequencial' => [1]])
</div>