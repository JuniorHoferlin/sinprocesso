<?php

namespace App\Events;

use App\Services\Auditor;
use Auth;

class AuditoriaEventHandler
{

    /**
     * @var Auditor
     */
    private $auditor;

    public function __construct(Auditor $auditor)
    {
        $this->auditor = $auditor;
    }

    /**
     * Ao criar um registro.
     *
     * @param string $evento
     * @param array $dados
     *
     * @return bool
     */
    public function onEloquentCreating($evento, $dados)
    {
        $dados = $dados[0];
        if (!in_array($dados->getTable(), ['auditoria', 'auditoria_acao'])) {
            $alterado = $dados->getAttributes();
            $this->auditor->adicionaAlteracoes($dados, $alterado, [], 'I');
        }

        return true;
    }

    /**
     * Ao atualizar um registro.
     *
     * @param $evento
     *
     * @return bool
     */
    public function onEloquentUpdating($evento, $dados)
    {
        $dados = $dados[0];
        if (!in_array($dados->getTable(), ['auditoria', 'auditoria_acao'])) {
            $original = $dados->getOriginal();
            $alterado = $dados->getAttributes();

            $this->auditor->adicionaAlteracoes($dados, $alterado, $original, 'U');
        }

        return true;
    }

    /**
     * Ao deletar um registro.
     *
     * @param $evento
     *
     * @return bool
     */
    public function onEloquentDeleting($evento, $dados)
    {
        $dados = $dados[0];
        if (!in_array($dados->getTable(), ['auditoria', 'auditoria_acao'])) {
            $original = $dados->getOriginal();
            $this->auditor->adicionaAlteracoes($dados, array(), $original, 'D');
        }

        return true;
    }

    public function onEloquentPivot($alteracoes, $relation)
    {
        $this->auditor->adicionarAlteracaoDeJoin($alteracoes, $relation);

        return true;
    }

    /**
     * @param $events
     */
    public function subscribe($events)
    {
        if (!app()->runningInConsole()) {
            $events->listen('eloquent.created: *', 'App\Events\AuditoriaEventHandler@onEloquentCreating');
            $events->listen('eloquent.deleted: *', 'App\Events\AuditoriaEventHandler@onEloquentDeleting');
            $events->listen('eloquent.updated: *', 'App\Events\AuditoriaEventHandler@onEloquentUpdating');
            $events->listen('eloquent.pivot', 'App\Events\AuditoriaEventHandler@onEloquentPivot');
        }
    }
}