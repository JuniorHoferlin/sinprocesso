<?php

namespace App\Models;

class TipoRota extends BaseModel
{

    protected $table = 'perm_tipo_rota';

    /**
     * Todas as rotas que pertecem a este tipo de rota.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function rotas()
    {
        return $this->hasMany(Rota::class, 'id_perm_tipo_rota', 'id');
    }
}
