<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('login/', 'login');
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('complete-todo-list/', [TodoController::class, 'completeTask']);
    Route::resource('/todo-list', TodoController::class);

    Route::delete('logout/', [AuthController::class, 'logout']);
});


