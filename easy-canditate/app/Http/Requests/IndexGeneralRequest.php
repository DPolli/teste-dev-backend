<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexGeneralRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string', 'max:255'],
            'sort' => ['nullable', 'string', 'in:name,email,type,is_admin,title,contractor,status'],
            'direction' => ['nullable', 'string', 'in:asc,desc'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:20']
        ];
    }

    public function messages(): array
    {
        return [
            'search.string' => 'O campo de busca deve ser um texto',
            'search.max' => 'O campo de busca não pode ter mais que 255 caracteres',
            'sort.string' => 'O campo de ordenação deve ser um texto',
            'sort.in' => 'O campo de ordenação deve ser um dos seguintes valores: name, email, type, is_admin, title, contractor, status',
            'direction.string' => 'O campo de direção deve ser um texto',
            'direction.in' => 'O campo de direção deve ser asc ou desc',
            'per_page.integer' => 'O campo de itens por página deve ser um número',
            'per_page.min' => 'O campo de itens por página deve ser no mínimo 1',
            'per_page.max' => 'O campo de itens por página deve ser no máximo 20'
        ];
    }
}
