<?php

namespace App\Http\Requests;

class SalvarTarefaRequest extends Request
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
            'titulo'        => 'required',
            'descricao'     => 'required',
            'id_area'       => 'required|integer',
            'prazo_minutos' => 'required'
        ];
    }
}
