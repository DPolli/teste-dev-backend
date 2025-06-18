<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseUpdateRequest;

class UpdateUserRequest extends BaseUpdateRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user')->id ?? $this->input('id');

        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => [
                'sometimes', 
                'string', 
                'email', 
                'unique:users,email,' . $userId
            ],
            'password' => ['sometimes', 'string', 'min:8'],
            'type' => ['sometimes', 'string', 'in:Candidato,Recrutador'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O nome deve ser um texto válido.',
            'name.max' => 'O nome não pode ter mais de 255 caracteres.',
            'email.string' => 'O e-mail deve ser um texto válido.',
            'email.email' => 'O e-mail deve ter um formato válido.',
            'email.unique' => 'Este e-mail já está sendo usado por outro usuário.',
            'password.string' => 'A senha deve ser um texto válido.',
            'password.min' => 'A senha deve ter pelo menos 8 caracteres.',
            'type.string' => 'O tipo deve ser um texto válido.',
            'type.in' => 'O tipo deve ser Candidato ou Recrutador.',
        ];
    }

}
