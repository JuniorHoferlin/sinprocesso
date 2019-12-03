<?php

namespace App\Observers;

use App\Models\Funcao;
use App\Models\TipoProcesso;
use App\Models\Usuario;

class TipoProcessoObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param TipoProcesso $tipo
     *
     * @return bool
     */
    public function deleting(TipoProcesso $tipo)
    {
        $tipo->tarefas()->sync([]);
        $tipo->regras()->delete();

        return true;
    }
}