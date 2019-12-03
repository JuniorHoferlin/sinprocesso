<?php

namespace App\Observers;

use App\Models\Rota;
use Illuminate\Support\Facades\Cache;

class RotaObserver
{

    /**
     * Depois de ter criado.
     *
     * @param Rota $rota
     *
     * @return bool
     */
    public function created(Rota $rota)
    {
        Cache::forget('rotas');

        return true;
    }

    /**
     * Depois de ter sido deletado.
     *
     * @param Rota $rota
     *
     * @return bool
     */
    public function deleted(Rota $rota)
    {
        Cache::forget('rotas');

        return true;
    }

    /**
     * Depois de ter sido atualizado.
     *
     * @param Rota $rota
     *
     * @return bool
     */
    public function updated(Rota $rota)
    {
        Cache::forget('rotas');

        return true;
    }
}