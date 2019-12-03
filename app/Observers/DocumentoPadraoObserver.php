<?php

namespace App\Observers;

use App\Models\DocumentoPadrao;
use File;

class DocumentoPadraoObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param DocumentoPadrao $documento
     *
     * @return bool
     */
    public function deleting(DocumentoPadrao $documento)
    {
        File::delete(public_path($documento->anexo));

        return true;
    }
}