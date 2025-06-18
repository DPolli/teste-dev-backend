<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserVacancy\{StoreUserVacancyRequest, UpdateUserVacancyRequest};
use App\Models\{User,UserVacancy,Vacancy};
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserVacancyController extends Controller
{
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Auth::user());

        $userVacancies = UserVacancy::with(['user', 'vacancy'])
            ->when(request('search'), function($query, $search) {
                $query->whereHas('user', function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhereHas('vacancy', function($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when(request('sort'), function($query, $sort) {
                $direction = request('direction', 'asc');
                if (in_array($sort, ['created_at', 'status'])) {
                    $query->orderBy($sort, $direction);
                } elseif ($sort === 'user') {
                    $query->orderBy(User::select('name')
                        ->whereColumn('users.id', 'user_vacancies.user_id'), $direction);
                } elseif ($sort === 'vacancy') {
                    $query->orderBy(Vacancy::select('title')
                        ->whereColumn('vacancies.id', 'user_vacancies.vacancy_id'), $direction);
                }
            })
            ->paginate(20);
        return response()->json($userVacancies);
    }

    public function store(StoreUserVacancyRequest $request): JsonResponse
    {
        //$this->authorize('create', User::find($request->user_id));

        $validatedData = $request->validated();
        $userVacancy = UserVacancy::create($validatedData);

        return response()->json($userVacancy, 201);
    }

    public function show(string $id): JsonResponse
    {
        $this->authorize('view', Auth::user());

        $userVacancy = UserVacancy::with(['user', 'vacancy'])->find($id);

        return response()->json($userVacancy);
    }

    public function destroy(string $id): JsonResponse
    {
        //$this->authorize('delete', Auth::user());

        $userVacancy = UserVacancy::find($id)->delete();

        return response()->json(null, 204);
    }
}
