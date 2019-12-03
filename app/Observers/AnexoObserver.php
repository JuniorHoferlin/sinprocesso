<?php

namespace App\Observers;

use App\Models\Anexo;
use File;

class AnexoObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param Anexo $anexo
     *
     * @return bool
     */
    public function deleting(Anexo $anexo)
    {
        File::delete(public_path($anexo->anexo));

        return true;
    }
}