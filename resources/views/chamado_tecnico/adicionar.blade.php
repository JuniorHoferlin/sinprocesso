<h1 class="m-t-xs text-center">Abrir chamado técnico</h1>
<hr>
<form id="abrir-chamado" method="post" action="{{ route('suporte.adicionar.post') }}">
    @include('partials.preenchimento_obrigatorio')
    @include('chamado_tecnico.form')
</form>