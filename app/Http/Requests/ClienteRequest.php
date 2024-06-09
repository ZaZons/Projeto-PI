<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClienteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    // TODO: validacao metodo de pagamento
    public function rules(): array
    {
        return [
            'name' => [
                'required',
            ],
            'email' => [
                'required',
                'email'
            ],
            'nif' => 'nullable|size:9',
            'file_foto' => 'image|max:4096'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' =>  'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' =>    'O formato do email é inválido',
            'nif.unique' => 'O NIF tem de ser único',
            'nif.size' => 'O NIF tem de ter 9 dígitos',
            'file_foto.image' => 'O ficheiro com a foto não é uma imagem',
            'file_foto.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 4 Mb',
        ];
    }
}
