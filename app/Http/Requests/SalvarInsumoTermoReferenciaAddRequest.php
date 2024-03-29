<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;

class SalvarInsumoTermoReferenciaAddRequest extends Request
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
            'id'            => 'required|integer',
            'quantidade'    => 'required|integer',
            'motivo'        => 'required'
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return ['status' => '0', 'errors' => $validator->errors()->all()];
    }
}
