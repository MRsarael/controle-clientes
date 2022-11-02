<?php

namespace App\Http\Form\Cliente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateClienteFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first(), 400);
        }
    }

    public function rules(): array
    {
        return [
            'nome'     => ['required', 'string', 'max:200'],
            'telefone' => ['required', 'string', 'max:11'],
            'cpf'      => ['required', 'string', 'max:11'],
            'placa'    => ['required', 'string', 'max:7']
        ];
    }
}
