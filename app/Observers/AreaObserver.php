<?php

namespace App\Observers;

use App\Models\Anexo;
use App\Models\Area;
use File;

class AreaObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param Area $area
     *
     * @return bool
     */
    public function deleting(Area $area)
    {
        $area->gruposAcesso()->sync([]);

        $areas = $area->funcoes->count();

        if ($areas > 0)
        {
            flash(sprintf('Não foi possível excluir esta área. Existe(m) %s funções ligada(s) a ela.', $areas), 'danger');

            return false;
        }

        return true;
    }
}