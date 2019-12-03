<?php

namespace App\Observers;

use App\Models\Anexo;
use App\Models\TarefaDocumento;
use File;

class TarefaDocumentoObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param TarefaDocumento $doc
     *
     * @return bool
     */
    public function deleting(TarefaDocumento $doc)
    {
        File::delete(public_path($doc->anexo));

        return true;
    }
}