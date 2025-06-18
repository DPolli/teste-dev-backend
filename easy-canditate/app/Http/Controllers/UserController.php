<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\{StoreUserRequest,UpdateUserRequest};
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserController extends Controller {

    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Auth::user());
            
        $users = User::query()
            ->when(request('search'), function($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            })
            ->when(request('sort'), function($query, $sort) {
                $direction = request('direction', 'asc');
                if (in_array($sort, ['name', 'email', 'type'])) {
                    $query->orderBy($sort, $direction);
                }
            })
            ->paginate(20);
            
        return response()->json($users);
    }

    public function store(StoreUserRequest $request): JsonResponse
    {
        $this->authorize('create', Auth::user());
            
        $validatedData = $request->validated();
            
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }
            
        $user = User::create($validatedData);
            
        return response()->json($user, 201);
    }

    public function show(User $user): JsonResponse
    {
        $this->authorize('view', Auth::user());
            
        return response()->json($user);
    }

    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $this->authorize('update', Auth::user());
            
        $validatedData = $request->validated();
            
        if (isset($validatedData['password'])) {
            $validatedData['password'] = bcrypt($validatedData['password']);
        }
            
        $user->update($validatedData);
            
        return response()->json($user->fresh());
    }

    public function destroy(User $user): JsonResponse
    {
        $this->authorize('delete', Auth::user());
            
        $user->delete();
            
        return response()->json(null, 204);
    }
}