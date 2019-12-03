<?php

namespace App\Models;

class InsumoTermoReferencia extends BaseModel
{

    protected $table = 'insumo_termo_referencia';

    /**
     * Dados do insumo desse InsumoTermoReferencia.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insumo()
    {
        return $this->belongsTo(Insumo::class, 'id_insumo', 'id');
    }

    /**
     * Dados do termoReferencia desse InsumoTermoReferencia.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function termoReferencia()
    {
        return $this->belongsTo(TermoReferencia::class, 'id_termo_referencia', 'id');
    }

    /**
     * Todas os InsumoTermoReferenciaAdd adicionados para este InsumoTermoReferencia.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function insumoTermoReferenciaAdd()
    {
        return $this->hasMany(InsumoTermoReferenciaAdd::class, 'id_insumo_termo_referencia', 'id');
    }

}
