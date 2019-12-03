<?php

namespace App\Models;

class Tarefa extends BaseModel
{

    /**
     * Os tipos de tarefas.
     *
     * @var array
     */
    public static $tipos = [
        'PADRÃO', 'COMPRA', 'ASSINATURA'
    ];

    protected $table = 'tarefa';

    /**
     * Calcula o tempo medio das tarefas.
     *
     * @param array $periodo
     *
     * @return mixed
     */
    public static function calcularTempoMedio($periodo)
    {
        // Busca as tarefas do periodo selecionado
        $tarefas = TarefaProcesso::with('ultimoHistorico')
                                 ->whereNotNull('data_finalizado')
                                 ->whereNotNull('data_abertura')
                                 ->where('data_abertura', '>=', $periodo['inicio'])
                                 ->where('data_finalizado', '<=', $periodo['fim'])
                                 ->get();

        // Soma a duração de cada tarefa (segundos) pra depois pegarmos a média
        $total = count($tarefas);
        $somaDuracao = $tarefas->sum(function ($tarefa) {
            return $tarefa->duracao;
        });


        $media = 0;
        if ($total) {
            $media = $somaDuracao / $total;
        }

        return gmdate("H:i:s", $media);
    }

    /**
     * Somente as tarefas que podem aparecer em qualquer processo.
     *
     * @param $builder
     *
     * @return mixed
     */
    public function scopeNaoExclusiva($builder)
    {
        return $builder->where('exclusiva', 'N');
    }

    /**
     * Seta o prazo da tarefa de dias (entrada pelo usuario) em minutos.
     */
    public function setPrazoMinutosAttribute($valor)
    {
        $this->attributes['prazo_minutos'] = intval(($valor * 24) * 60);
    }

    /**
     * Retorna o prazo em dias da tarefa.
     *
     * @return int
     */
    public function getPrazoDiasAttribute()
    {
        return intval(($this->attributes['prazo_minutos'] / 24) / 60);
    }

    /**
     * A area que esta tarefa pertence.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'id_area', 'id');
    }

    /**
     * Grupo Acesso Area que a tarefa pertence
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grupoAcessoArea()
    {
        return $this->belongsTo(GrupoAcessoArea::class, 'id_grupo_acesso_area', 'id');
    }

    /**
     * As dependencias desta tarefa.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function dependencias()
    {
        return $this->belongsToMany(Tarefa::class, 'tarefa_dependencia', 'id_tarefa', 'id_dependencia')
                    ->withPivot(['created_at', 'updated_at']);
    }

}
