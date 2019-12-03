<?php

namespace App\Models;

class GrupoAcesso extends BaseModel
{

    protected $table = 'grupo_acesso';

    /**
     * Lista cada grupo de acesso com sua area separada.
     *
     * @param bool $exibirTodos
     *
     * @return \Illuminate\Support\Collection
     */
    public static function listarGruposAreas($exibirTodos = false)
    {
        $grupos = self::with('areas');

        if (!$exibirTodos) {
            $grupos->where('super_admin', 'N');
        }

        $grupos = $grupos->orderBy('descricao', 'ASC')->get();

        $gruposAreas = collect([]);
        $grupos->each(function ($grupo) use (&$gruposAreas) {
            $grupo->areas->each(function ($area) use (&$gruposAreas, $grupo) {
                $gruposAreas->push(
                    [
                        'id'        => $area->pivot->id,
                        'grupo'     => $grupo,
                        'descricao' => "$grupo->descricao/$area->descricao"
                    ]
                );
            });
        });

        return $gruposAreas;
    }

    /**
     * Todas as áreas ligadas a este grupo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function areas()
    {
        return $this->belongsToMany(Area::class, 'grupo_acesso_area', 'id_grupo_acesso', 'id_area')
                    ->withPivot(['id', 'updated_at', 'created_at']);
    }

    /**
     * Todas as rotas que este grupo de acesso esta permitido de acessar.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rotas()
    {
        return $this->belongsToMany(Rota::class, 'perm_rota_grupo_acesso', 'id_grupo_acesso', 'id_perm_rota');
    }

}
