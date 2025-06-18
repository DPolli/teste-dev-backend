<?php

namespace App\Http\Requests\Vacancy;

use Illuminate\Foundation\Http\FormRequest;

class StoreVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string','max:600'],
            'contractor' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'in:CLT,PJ,Freelancer'],
            'status' => ['required', 'string', 'in:Aberta,Pausada,Fechada'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'O título da vaga é obrigatório.',
            'description.required' => 'A descrição da vaga é obrigatória.',
            'contractor.required' => 'O nome do contratante é obrigatório.',
            'type.required' => 'O tipo de contratação é obrigatório.',
            'type.in' => 'O tipo de contratação deve ser CLT, PJ ou Freelancer.',
            'status.required' => 'O status da vaga é obrigatório.',
            'status.in' => 'O status da vaga deve ser Aberta, Pausada ou Fechada.',
        ];
    }
}