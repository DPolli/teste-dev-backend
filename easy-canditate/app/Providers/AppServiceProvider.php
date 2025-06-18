<?php

namespace App\Providers;

use App\Models\{User,Vacancy,UserVacancy};
use App\Policies\{UserPolicy,VacancyPolicy,UserVacancyPolicy};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Vacancy::class => VacancyPolicy::class,
        UserVacancy::class => UserVacancyPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}