<?php

namespace App\Http\Requests;

class SalvarTipoProcessoRequest extends Request
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
            'descricao'     => 'required',
            'id_formulario' => 'required|integer',
            'tr'            => 'required|in:S,N'
        ];
    }
}
