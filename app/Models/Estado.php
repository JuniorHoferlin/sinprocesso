<?php

namespace App\Models;

class Estado extends BaseModel
{

    protected $table = 'estado';

    /**
     * Todas as cidades deste estado.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cidades()
    {
        return $this->hasMany(Cidade::class, 'id_estado', 'id');
    }

}
