<?php

namespace App\Models;

class HistoricoTarefa extends BaseModel
{

    public static $status = ['ABERTO', 'CONCLUIDO', 'PENDENTE', 'CANCELADO', 'REPORTADA'];

    protected $table = 'historico_tarefa';

}
