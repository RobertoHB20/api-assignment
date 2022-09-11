<?php

use App\Http\Controllers\ApiUsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::prefix('users')->group(function(){
    Route::get('', [ApiUsersController::class, 'index']);
    Route::get('/{id}', [ApiUsersController::class, 'getById'])->where(['id'=>'^[0-9]+$']);
    Route::post('', [ApiUsersController::class, 'saveUser']);
    Route::put('/{id}', [ApiUsersController::class, 'updateUser'])->where(['id'=>'^[0-9]+$']);
});

Route::any('{path}', function(){
    return response()->json(['message' => "Route requested doesn't exist, please verify your request"], 404);
})->where('path', '.*');


