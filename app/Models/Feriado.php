<?php

namespace App\Models;

class Feriado extends BaseModel
{

    public static $tiposFeriados = [
        'ESTADUAL',
        'FACULTATIVO',
        'FEDERAL'
    ];

    protected $table = 'feriado';

    protected $dates = ['data'];

    /**
     * Retorna se o feriado cai em um dia de semana;
     *
     * @return
     */
    public function getDiaSemanaAttribute()
    {
        $data = $this->data;
        
        return $data->isWeekday();
    }

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
