<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GrupoRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'query' => 'required',
            'codpes_supervisor' => 'required|integer',
            'codpes_autorizador' => 'required|integer',
            'inicio_folha' => 'required|integer',
            'fim_folha' => 'required|integer',
        ];

        return $rules;
    }
}
