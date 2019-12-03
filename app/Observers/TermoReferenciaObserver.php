<?php

namespace App\Observers;

use App\Models\TermoReferencia;
use File;
use Illuminate\Support\Facades\DB;

class TermoReferenciaObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param TermoReferencia $termo
     *
     * @return bool
     */
    public function deleting(TermoReferencia $termo)
    {
        $ids = [];
        $termo->insumos->each(function ($insumo) use (&$ids) {
            $ids[] = $insumo->pivot->id;
        });

        $existe = DB::table('processo_insumo_termo_ref')
                    ->whereIn('id_insumo_termo_referencia', $ids)
                    ->count();


        if ($existe > 0) {
            flash(sprintf('Não foi possível excluir este termo de referência. Existe(m) %s insumo(s) em tramite de processo.', $existe), 'danger');

            return false;
        }

        $termo->insumos()->sync([]);

        return true;
    }
}