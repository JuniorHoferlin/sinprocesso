<?php

namespace App\Observers;

use App\Models\Formulario;

class FormularioObserver
{

    /**
     * Quando estiver deletando.
     *
     * @param Formulario $form
     *
     * @return bool
     */
    public function deleting(Formulario $form)
    {
        $tipos = $form->tiposProcesso->count();
        if ($tipos > 0) {
            flash(sprintf('Não foi possível excluir teste formulário. Existe(m) %s tipo(s) de processo(s) ligado(s) a ele.', $tipos), 'danger');

            return false;
        }

        $tarefas = $form->tarefas->count();
        if ($tarefas > 0) {
            flash(sprintf('Não foi possível excluir teste formulário. Existe(m) %s tarefa(s) ligada(s) a ele.', $tarefas), 'danger');

            return false;
        }

        $processos = $form->processos->count();
        if ($processos > 0) {
            flash(sprintf('Não foi possível excluir teste formulário. Existe(m) %s processo(s) ligado(s) a ele.', $processos), 'danger');

            return false;
        }


        $form->campos()->sync([]);

        return true;
    }
}