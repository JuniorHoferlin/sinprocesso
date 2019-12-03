<?php

namespace App\Models;

class ProcessoInsumoTermoReferencia extends BaseModel
{

    protected $table = 'processo_insumo_termo_ref';

    public function getQuantidadeCompradaAttribute()
    {
        $quantidade = 0;

        $this->tarefaInsumo->each(function ($tarefaInsumo) use (&$quantidade) {
            $quantidade = $quantidade + $tarefaInsumo->quantidade;
        });

        return $quantidade;
    }

    public function getQuantidadePendenteAttribute()
    {
        $comprado = 0;
        $this->tarefaInsumo->each(function ($tarefaInsumo) use (&$comprado) {
            $comprado = $comprado + $tarefaInsumo->quantidade;
        });

        return $this->insumoTermo->quantidade - $comprado;
    }

    public function insumoTermo()
    {
        return $this->belongsTo(InsumoTermoReferencia::class, 'id_insumo_termo_referencia', 'id');
    }

    public function processo()
    {
        return $this->belongsTo(Processo::class, 'id_processo', 'id');
    }

    public function tarefaInsumo()
    {
        return $this->hasMany(TarefaInsumo::class, 'id_processo_insumo', 'id');
    }

}
