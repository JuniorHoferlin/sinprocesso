<?php

namespace App\Models;

class Rota extends BaseModel
{

    protected $table = 'perm_rota';

    /**
     * Os dados do tipo de rota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoRota::class, 'id_perm_tipo_rota', 'id');
    }

    /**
     * Todos os grupos de acesso que tem essa permissão.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function grupos()
    {
        return $this->belongsToMany(GrupoAcesso::class, 'perm_rota_grupo_acesso', 'id_perm_rota', 'id_grupo_acesso');
    }
}
