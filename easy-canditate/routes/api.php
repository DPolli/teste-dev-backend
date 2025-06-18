<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/teste', function(){
    return 'Chegou!';
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('users', App\Http\Controllers\UserController::class);
    Route::apiResource('vacancies', App\Http\Controllers\VacancyController::class);
    Route::put('vacancies/{vacancy}/pause', [App\Http\Controllers\VacancyController::class, 'pauseVacancy']);
    Route::apiResource('candidates', App\Http\Controllers\UserVacancyController::class);
});

Route::post('/import-data', [App\Http\Controllers\TemperatureDataController::class, 'import']);
//Route::get('/data-analysis', [App\Http\Controllers\DataAnalysisController::class, 'analyze']);
