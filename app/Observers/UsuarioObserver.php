<?php

namespace App\Observers;

use App\Models\Anexo;
use App\Models\Usuario;
use File;

class UsuarioObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param Usuario $usuario
     *
     * @return bool
     */
    public function deleting(Usuario $usuario)
    {
        $usuario->gruposAcesso()->sync([]);

        return true;
    }
}