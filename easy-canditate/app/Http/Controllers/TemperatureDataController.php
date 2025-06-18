<?php

namespace App\Http\Controllers;

use App\Jobs\ImportTemperatureDataCsvJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TemperatureDataController extends Controller {

    public function import(Request $request): JsonResponse    {
        ImportTemperatureDataCsvJob::dispatch($request->file('file')->path());
        return response()->json(['message' => 'Importação começou...']);
    }

}