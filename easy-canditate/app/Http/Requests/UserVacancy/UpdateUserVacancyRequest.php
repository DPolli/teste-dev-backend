<?php

namespace App\Http\Requests\UserVacancy;

use App\Http\Requests\BaseUpdateRequest;

class UpdateUserVacancyRequest extends BaseUpdateRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'integer']
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'O ID da candidatura é obrigatório',
            'id.integer' => 'O ID da candidatura deve ser um número inteiro'
        ];
    }
}
