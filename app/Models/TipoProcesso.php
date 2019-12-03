<?php

namespace App\Models;

class TipoProcesso extends BaseModel
{

    protected $table = 'tipo_processo';

    /**
     * Associa uma tarefa dentro de um tipo de processo.
     *
     * @param int $id ID da tarefa.
     *
     * @return bool
     */
    public function associarTarefa($id)
    {
        $tarefa = Tarefa::find($id);
        $tipo = $tarefa->tipo;

        // Vamos permitir somente um tipo de tarefa COMPRA ou ASSINATURA dentro do tipo de processo
        if (in_array($tipo, ['COMPRA', 'ASSINATURA'])) {
            $encontrado = $this->tarefas->filter(function ($tarefa) use ($tipo, $id) {
                return $tarefa->tipo == $tipo && $tarefa->id != $id;
            });

            if (count($encontrado) > 0) {
                return false;
            }
        }

        // Sempre ao associar tarefa, joga ela por último na ordem das tarefas
        $maxOrdem = (int)$this->tarefas()->max('ordem');

        return $this->tarefas()->toggle(
            [
                $id => ['ordem' => $maxOrdem + 1],
            ]
        );
    }

    /**
     * Todas as tarefas ligadas a este processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tarefas()
    {
        return $this->belongsToMany(Tarefa::class, 'tipo_processo_tarefa', 'id_tipo_processo', 'id_tarefa')
                    ->withPivot(['created_at', 'updated_at', 'ordem'])->orderBy('ordem', 'ASC');
    }

    /**
     * Dados do formulário deste tipo de processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function formulario()
    {
        return $this->belongsTo(Formulario::class, 'id_formulario', 'id');
    }

    /**
     * Todas as regras criadas para este tipo de processo.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function regras()
    {
        return $this->hasMany(RegraProcesso::class, 'id_tipo_processo', 'id');
    }

    /**
     * Todos os grupos de acesso/area que podem criar este tipo de processo.
     *
     * @return \App\Database\Eloquent\Relations\CustomBelongsToMany
     */
    public function gruposAcesso()
    {
        return $this->belongsToMany(GrupoAcessoArea::class, 'tipo_processo_grupo_ac_area', 'id_tipo_processo', 'id_grupo_acesso_area');
    }

}
