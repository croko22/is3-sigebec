<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BecaController;

Route::apiResource('becas', BecaController::class);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');