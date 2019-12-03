<?php

namespace App\Models;

class Formulario extends BaseModel
{

    protected $table = 'formulario';

    /**
     * Todos os campos deste formulário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campos()
    {
        return $this->hasMany(FormularioCampo::class, 'id_formulario', 'id');
    }

    /**
     * Todos os tipos de processo que estão utilizando este formulário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tiposProcesso()
    {
        return $this->hasMany(TipoProcesso::class, 'id_formulario', 'id');
    }

    /**
     * Todas as tarefas que estão utilizando este formulário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tarefas()
    {
        return $this->hasMany(Tarefa::class, 'id_formulario', 'id');
    }

    /**
     * Todos os processos ligados a este formulário.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function processos()
    {
        return $this->hasMany(Processo::class, 'id_formulario', 'id');
    }

}
