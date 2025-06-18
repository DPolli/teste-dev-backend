<?php

namespace App\Policies;

use App\Models\Vacancy;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class VacancyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool|Response
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny('Você deve ser administrador para visualizar todas as vagas.');
    }

    public function view(User $user, Vacancy $vacancy): bool
    {
        return $user->id === $vacancy->user_id || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->isAdmin() || $user->isRecruiter();
    }

    public function update(User $user, Vacancy $vacancy): bool
    {
        return $user->id === $vacancy->user_id || $user->isAdmin();
    }

    public function delete(User $user, Vacancy $vacancy): bool
    {
        return $user->id === $vacancy->user_id || $user->isAdmin();
    }
}