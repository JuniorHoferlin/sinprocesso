<?php

namespace App\Http\Requests;

class SalvarUsuarioRequest extends Request
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
            'nome'           => 'required',
            'cpf'            => 'required',
            'id_funcao_area' => 'required|integer',
            'login'          => 'required',
            'email'          => 'required'
        ];
    }
}
