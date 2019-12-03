<?php

namespace App\Models;

class TermoReferencia extends BaseModel
{

    protected $table = 'termo_referencia';

    public static function prepararRequestParaInsert($data = [])
    {//dd($data);
        $retorno = [];
        foreach ($data as $d) {
            $retorno[] = [
                'id_insumo'     => $d['id'],
                'quantidade'    => $d['quantidade'],
                'media_consumo' => $d['media_consumo'],
                'valor'         => $d['valor'],
            ];
        }

        // dd($retorno);
        return $retorno;
    }

    /**
     * Todas os insumos ligados a este termo de referencia.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function insumos()
    {
        return $this->belongsToMany(Insumo::class, 'insumo_termo_referencia', 'id_termo_referencia', 'id_insumo')
            ->withPivot(['created_at', 'updated_at', 'id', 'quantidade', 'valor', 'media_consumo']);
    }

    public function processos()
    {
        return $this->hasMany(Processo::class, 'id_termo_referencia', 'id');
    }
}
