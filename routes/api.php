<?php

use App\Http\Controllers\Application\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/messages', [MessageController::class, 'store']);
Route::get('/messages/{id}', [MessageController::class, 'index']);
