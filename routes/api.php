<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BecaController;
use App\Http\Controllers\Api\ConvocatoriaController;

Route::apiResource('becas', BecaController::class);
Route::apiResource('convocatorias', ConvocatoriaController::class);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');