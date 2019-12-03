<?php

namespace App\Models;

// Esse model nao era pra existir...mas...vamo lá.
class GrupoAcessoArea extends BaseModel
{

    protected $table = 'grupo_acesso_area';

    /**
     * Dados do grup de acesso.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dadosGrupo()
    {
        return $this->belongsTo(GrupoAcesso::class, 'id_grupo_acesso', 'id');
    }

}
