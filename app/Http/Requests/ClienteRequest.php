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
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                Rule::unique('users', 'name')->ignore($this->user_id),
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($this->user_id),
            ],
            'admin' =>              'required|boolean',
            'genero' =>             'required|in:M,F',
            'curso' =>              'required|exists:cursos,abreviatura',
            'numero' =>             'required|integer',
            'password_inicial' =>   'sometimes|required',
            'file_foto' => 'sometimes|image|max:4096'
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
            'name.unique' =>    'O nome tem que ser único',
            'email.required' => 'O email é obrigatório',
            'email.email' =>    'O formato do email é inválido',
            'email.unique' =>   'O email tem que ser único',
            'admin.required' => 'O campo "admin" é obrigatório',
            'admin.boolean' =>  'O campo "admin" tem que ser um booleano',
            'genero.required' =>    'O gênero é obrigatório',
            'genero.in' =>          'O gênero tem que ser M ou F (Masculino ou Feminino)',
            'curso.required' =>     'O curso é obrigatório',
            'curso.exists' =>       'O curso não existe na base de dados',
            'numero.required' =>    'O nº de aluno é obrigatório',
            'numero.integer' =>     'O nº de aluno tem que ser inteiro',
            'password_inicial.required' => 'A password inicial é obrigatória',
            'file_foto.image' => 'O ficheiro com a foto não é uma imagem',
            'file_foto.size' => 'O tamanho do ficheiro com a foto tem que ser inferior a 4 Mb',
        ];
    }
}
