<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\{StoreVacancyRequest,UpdateVacancyRequest};
use App\Models\Vacancy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class VacancyController extends Controller
{
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Auth::user());

        $vacancies = Vacancy::query()
            ->when(request('search'), function($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('contractor', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })
            ->when(request('sort'), function($query, $sort) {
                $direction = request('direction', 'asc');
                if (in_array($sort, ['title', 'contractor', 'type', 'status'])) {
                    $query->orderBy($sort, $direction);
                }
            })
            ->paginate(20);
        return response()->json($vacancies);
    }

    public function store(StoreVacancyRequest $request): JsonResponse
    {
        $this->authorize('create', Auth::user());

        $validatedData = $request->validated();
        $validatedData['user_id'] = Auth::user()->id;
        $vacancy = Vacancy::create($validatedData);
        
        return response()->json($vacancy, 201);
    }

    public function show(string $id): JsonResponse
    {
        $this->authorize('view', Auth::user());

        $vacancy = Vacancy::find($id);

        return response()->json($vacancy);
    }

    public function update(UpdateVacancyRequest $request, string $id): JsonResponse
    {
        $this->authorize('update', Auth::user());

        $validatedData = $request->validated();
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->update($validatedData);

        return response()->json($vacancy->fresh());
    }
    
    public function pauseVacancy(string $id): JsonResponse
    {
        $this->authorize('update', Auth::user());

        $vacancy = Vacancy::findOrFail($id);
        $vacancy->update(['status' => 'Pausada']);

        return response()->json($vacancy->fresh());
    }

    public function destroy(string $id): JsonResponse
    {
        $this->authorize('delete', Auth::user());

        $vacancy = Vacancy::find($id)->delete();

        return response()->json(null, 204);
    }
}
