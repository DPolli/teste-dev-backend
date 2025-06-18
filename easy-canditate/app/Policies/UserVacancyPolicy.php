<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserVacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserVacancyPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool|Response
    {
        return $user->isAdmin()
            ? Response::allow()
            : Response::deny('Você deve ser administrador para visualizar todas candidaturas.');
    }

    public function view(User $user, UserVacancy $userVacancy): bool
    {
        return $user->id === $userVacancy->user_id || $user->isAdmin();
    }

    public function create(User $user): bool
    {
        return $user->id == Auth::user()->id || Auth::user()->is_admin;
    }

    public function update(User $user, UserVacancy $userVacancy): bool
    {
        return $user->id === $userVacancy->user_id || $user->isAdmin();
    }

    public function delete(User $user, UserVacancy $userVacancy): bool
    {
        return $user->id == $userVacancy->user_id || $user->isAdmin();
    }
}
