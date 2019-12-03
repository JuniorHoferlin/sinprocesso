<?php

namespace App\Observers;

use App\Models\GrupoAcesso;

class GrupoAcessoObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param GrupoAcesso $grupo
     *
     * @return bool
     */
    public function deleting(GrupoAcesso $grupo)
    {
        // limpa as areas
        $grupo->areas()->sync([]);

        // limpa as rotas
        $grupo->rotas()->sync([]);

        return true;
    }
}