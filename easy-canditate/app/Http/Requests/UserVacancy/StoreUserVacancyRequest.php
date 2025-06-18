<?php

namespace App\Http\Requests\UserVacancy;

use App\Models\{User,Vacancy,UserVacancy};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;

class StoreUserVacancyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => ['required', 'integer'],
            'vacancy_id' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_id.required' => 'O campo usuário é obrigatório',
            'user_id.integer' => 'O campo usuário deve ser um número inteiro',
            'vacancy_id.required' => 'O campo vaga é obrigatório',
            'vacancy_id.integer' => 'O campo vaga deve ser um número inteiro'
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function ($validator) {
            $userId = $this->input('user_id');
            $user = $userId ? User::find($userId) : Auth::user();
            $vacancyId = $this->input('vacancy_id');

            if ($user->type !== 'Candidato' && $user->isAdmin() == false) {
                $validator->errors()->add('user_type', 'Apenas candidatos podem se inscrever em vagas');
                return;
            }

            $vacancy = Vacancy::find($vacancyId);
            if ($vacancy && $vacancy->status !== 'Aberta') {
                $validator->errors()->add('vacancy_status', 'Esta vaga não está mais aberta para inscrições');
                return;
            }

            $findCandidate = UserVacancy::where('user_id', $user->id)
                ->where('vacancy_id', $vacancyId)
                ->exists();

            if ($findCandidate) {
                $validator->errors()->add('duplicate', 'Você já está inscrito nesta vaga');
            }
        });
    }
    
};
