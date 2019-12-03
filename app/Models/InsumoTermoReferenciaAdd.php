<?php

namespace App\Models;

class InsumoTermoReferenciaAdd extends BaseModel
{

    protected $table = 'insumo_termo_referencia_add';

    /**
     * Dados do InsumoTermoReferencia desse InsumoTermoReferenciaAdd.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function insumoTermoReferencia()
    {
        return $this->belongsTo(InsumoTermoReferencia::class, 'id_insumo_termo_referencia', 'id');
    }

    /**
     * Dados do Usuario desse InsumoTermoReferenciaAdd.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id');
    }

}
