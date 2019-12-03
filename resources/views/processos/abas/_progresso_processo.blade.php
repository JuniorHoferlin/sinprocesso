<small>Tarefas completadas até o momento: {{ $detalhesTarefas['concluido'] }} de {{ $detalhesTarefas['total'] }}</small>
<div class="progress progress-striped active" style="background: #ddd;">
    <div style="width: {{ $processo->porcentagem_concluido }}%; min-width: 5%;" class="progress-bar">
        {{ $processo->porcentagem_concluido }}%
    </div>
</div>