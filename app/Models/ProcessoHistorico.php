<?php

namespace App\Models;

class ProcessoHistorico extends BaseModel
{

    public static $status = ['ABERTO', 'FINALIZADO', 'BLOQUEADO'];

    protected $table = 'processo_historico';

}
