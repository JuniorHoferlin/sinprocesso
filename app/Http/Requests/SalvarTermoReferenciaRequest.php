<?php

namespace App\Http\Requests;

class SalvarTermoReferenciaRequest extends Request
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'diretoria'               => 'required',
            'fonte_recurso'           => 'required',
            'classificacao_orcamento' => 'required',
            'natureza_despesa'        => 'required',
            'bloco'                   => 'required',
            'componente'              => 'required',
            'acao'                    => 'required',
            'programa_ppa'            => 'required',
            'ata_regristro_preco'     => 'required'
        ];
    }
}
