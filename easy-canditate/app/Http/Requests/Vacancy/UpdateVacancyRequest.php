<?php

namespace App\Http\Requests\Vacancy;

use App\Http\Requests\BaseUpdateRequest;

class UpdateVacancyRequest extends BaseUpdateRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['string', 'max:255'],
            'description' => ['string','max:600'],
            'contractor' => ['string', 'max:255'],
            'type' => ['string', 'in:CLT,PJ,Freelancer'],
            'status' => ['string', 'in:Aberta,Pausada,Fechada'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.string' => 'O título deve ser um texto',
            'title.max' => 'O título não pode ter mais que 255 caracteres',
            'description.string' => 'A descrição deve ser um texto',
            'description.max' => 'A descrição não pode ter mais que 600 caracteres',
            'contractor.string' => 'O contratante deve ser um texto',
            'contractor.max' => 'O contratante não pode ter mais que 255 caracteres',
            'type.string' => 'O tipo deve ser um texto',
            'type.in' => 'O tipo deve ser CLT, PJ ou Freelancer',
            'status.string' => 'O status deve ser um texto',
            'status.in' => 'O status deve ser Aberta, Pausada ou Fechada',
        ];
    }

}
