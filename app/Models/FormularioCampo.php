<?php

namespace App\Models;

use App\Services\RenderizaCampo;

class FormularioCampo extends BaseModel
{

    protected $table = 'formulario_campo';

    /**
     * Renderiza o campo conforme o seu tipo.
     *
     * @return $this
     */
    public function renderizar()
    {
        $tipo = $this->tipo->tipo;

        return view("partials.campos.$tipo")->with('campo', $this);
    }

    public function setOpcoesAttribute($opcoes)
    {
        if (is_null($opcoes)) {
            $opcoes = '';
        }

        $this->attributes['opcoes'] = $opcoes;
    }

    /**
     * O tipo de campo deste campo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tipo()
    {
        return $this->belongsTo(TipoCampo::class, 'id_tipo_campo', 'id');
    }
}
