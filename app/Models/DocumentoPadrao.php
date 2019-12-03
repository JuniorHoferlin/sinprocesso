<?php

namespace App\Models;

class DocumentoPadrao extends BaseModel
{

    protected $table = 'documento_padrao';

    /**
     * Formata a data do feriado antes de salvar no banco.
     *
     * @param string $data
     */
    public function setDataAttribute($data)
    {
        $this->attributes['data'] = formatarData($data, 'Y-m-d');
    }
}
