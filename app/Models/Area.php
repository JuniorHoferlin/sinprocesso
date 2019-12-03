<?php

namespace App\Models;

class Area extends BaseModel
{

    protected $table = 'area';

    /**
     * Retorna um array com os dados da area e seus leveis.
     *
     * @param array $areas
     * @param int $nivel
     * @param array $marcar
     *
     * @return array
     */
    public static function listarAreasLeveis($areas = [], $nivel = 0, $marcar = [])
    {
        if (empty($areas))
        {
            $areas = self::whereNull('id_area')->with('areasRecursiva')->orderBy('descricao', 'ASC')->get();
        }

        $retorno = [];
        foreach ($areas as $area)
        {
            $retorno[] = [
                'id'       => $area->id,
                'text'     => $area->descricao,
                'level'    => $nivel,
                'selected' => in_array($area->id, $marcar) ? 1 : 0,
            ];

            if (count($area->areasRecursiva) > 0)
            {
                $retorno = array_merge($retorno, self::listarAreasLeveis($area->areasRecursiva, $nivel + 1, $marcar));
            }
        }

        return $retorno;
    }

    /**
     * Todos os grupos de acesso desta área.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function gruposAcesso()
    {
        return $this->belongsToMany(GrupoAcesso::class, 'grupo_acesso_area', 'id_area', 'id_grupo_acesso')
            ->withPivot(['created_at', 'updated_at', 'id']);
    }

    /**
     * A area que esta area depende.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }

    public function areasRecursiva()
    {
        return $this->areas()->with('areasRecursiva');
    }

    /**
     * Todas as areas que dependem desta area.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function areas()
    {
        return $this->hasMany(Area::class, 'id_area', 'id');
    }

    /**
     * Todas as funções que estao utilizando essa area
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function funcoes()
    {
        return $this->belongsToMany(Funcao::class, 'funcao_area', 'id_area', 'id_funcao')
            ->withPivot(['created_at', 'updated_at', 'id']);
    }

}
