<?php

namespace App\Models;

class TarefaDocumento extends BaseModel
{

    protected $table = 'tarefa_processo_documento';

    /**
     * Dados do usuário que incluiu o documento.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }
}
