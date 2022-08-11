<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OcorrenciaRequest extends FormRequest
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
                'place_id' => 'required',
                'ocorrencia' => 'required',
            ];

            return $rules;
        }

    public function messages()
    {
        return [
            'place_id.required' => 'O campo "Local" é obrigatório.'
        ];
    }
}
