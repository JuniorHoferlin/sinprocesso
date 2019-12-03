<?php

namespace App\Observers;

use App\Models\Funcao;
use App\Models\Usuario;

class FuncaoObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param Funcao $funcao
     *
     * @return bool
     */
    public function deleting(Funcao $funcao)
    {
        $ids = [];
        $funcao->areas->each(function ($area) use (&$ids) {
            $ids[] = $area->pivot->id;
        });

        $usuarios = Usuario::whereIn('id_funcao_area', $ids)->count();
        if ($usuarios > 0) {
            flash(sprintf('Não foi possível excluir esta função. Existe(m) %s usuário(s) ligado(s) a ela.', $usuarios), 'danger');

            return false;
        }

        $funcao->areas()->sync([]);

        return true;
    }
}