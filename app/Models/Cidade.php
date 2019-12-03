<?php

namespace App\Models;

class Cidade extends BaseModel
{

    protected $table = 'cidade';

    /**
     * Dados do estado dessa cidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function estado()
    {
        return $this->belongsTo(Estado::class, 'id_estado', 'id');
    }

    /**
     * Todos os usuários desta cidade.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'id_cidade', 'id');
    }
}
