<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

// TODO: funcionariorequest
class FuncionarioRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'password_inicial' =>   'sometimes|required',
            'tipo' =>              'required|in:A,F',
            'bloqueado' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' =>  'O nome é obrigatório',
            'email.required' => 'O email é obrigatório',
            'email.email' =>    'O formato do email é inválido',
            'password_inicial.required' => 'A password inicial é obrigatória',
            'tipo.required' => 'O tipo é obrigatório',
            'tipo.in' => 'O tipo tem de ser Administrador ou Funcionário',
            'bloqueado.required' => 'O formato do bloqueio é inválido',
        ];
    }
}
