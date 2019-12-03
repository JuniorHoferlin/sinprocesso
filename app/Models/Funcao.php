<?php

namespace App\Models;

class Funcao extends BaseModel
{

    protected $table = 'funcao';

    /**
     * Lista cada função com sua area separada.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function listaFuncoesAreas()
    {
        $funcoes = self::with('areas')->orderBy('descricao', 'ASC')->get();

        $funcoesAreas = collect([]);
        $funcoes->each(function ($funcao) use (&$funcoesAreas) {
            $funcao->areas->each(function ($area) use (&$funcoesAreas, $funcao) {
                $funcoesAreas->push(
                    [
                        'id'        => $area->pivot->id,
                        'funcao'    => $funcao,
                        'descricao' => "$funcao->descricao/$area->descricao"
                    ]
                );
            });
        });

        return $funcoesAreas;
    }

    /**
     * Todas as áreas ligadas a esta função.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'funcao_area', 'id_funcao', 'id_area')
                    ->withPivot(['created_at', 'updated_at', 'id']);
    }

}
