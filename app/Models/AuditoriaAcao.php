<?php

namespace App\Models;

class AuditoriaAcao extends BaseModel
{
    protected $table = 'auditoria_acao';

    /**
     * Retorna o texto da ação feita na tabela.
     *
     * $acao->acao_tabela_texto
     *
     * @return string
     */
    public function getAcaoTabelaTextoAttribute()
    {
        switch ($this->attributes['acao_tabela']) {
            case 'I':
                return 'Adicionar';
                break;
            case 'U':
                return 'Atualizar';
                break;
            case 'D':
                return 'Excluir';
                break;
        }

        return 'não identificado';
    }

    /**
     * Retorna o nome dos campos alterados do conteúdo deste registro de auditoria.
     *
     * $acao->dados_campos
     *
     * @return array
     */
    public function getDadosCamposAttribute()
    {
        $dadosOld = json_decode($this->attributes['dados_old']);
        $dadosNew = json_decode($this->attributes['dados_new']);
        $dadosAlt = json_decode($this->attributes['dados_alt']);

        $dados = $dadosOld;
        if (count($dados) == 0) {
            $dados = $dadosNew;
        }

        $retorno = [
            'campos' => [],
            'old'    => [],
            'new'    => []
        ];
        foreach ($dados as $chave => $valor) {
            $retorno['campos'][] = $chave;

            $alterado = false;
            if (isset($dadosAlt->$chave)) {
                $alterado = true;
            }

            $retorno['old'][$chave] = [
                'valor'    => isset($dadosOld->$chave) ? $dadosOld->$chave : null,
                'alterado' => $alterado
            ];

            $retorno['new'][$chave] = [
                'valor'    => isset($dadosNew->$chave) ? $dadosNew->$chave : null,
                'alterado' => $alterado
            ];
        }

        return $retorno;
    }

    public function setDadosNewAttribute($valor)
    {
        $this->attributes['dados_new'] = json_encode($valor);
    }

    public function setDadosOldAttribute($valor)
    {
        $this->attributes['dados_old'] = json_encode($valor);
    }

    public function setDadosAltAttribute($valor)
    {
        $this->attributes['dados_alt'] = json_encode($valor);
    }
}
