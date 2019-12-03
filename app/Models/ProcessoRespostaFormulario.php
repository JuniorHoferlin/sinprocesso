<?php

namespace App\Models;

class ProcessoRespostaFormulario extends BaseModel
{

    protected $table = 'processo_resposta_formulario';

    /**
     * Retorna a resposta em forma de texto.
     *
     * @return string
     */
    public function getRespostaCompletaAttribute()
    {
        $resposta = json_decode($this->attributes['resposta']);

        if (is_array($resposta)) {
            $resposta = implode(',', $resposta);
        } else {
            $resposta = $this->attributes['resposta'];
        }

        return $resposta;
    }

    /**
     * Dados do campo desta resposta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campo()
    {
        return $this->belongsTo(FormularioCampo::class, 'id_formulario_campo', 'id');
    }
}
