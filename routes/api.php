<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClothesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('hello', [AuthController::class, 'hello']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function ()
{
    
    Route::get('/clothes', [ClothesController::class, 'index']);
    Route::post('/clothes', [ClothesController::class, 'store']);
    Route::delete('/clothes/{id}', [ClothesController::class, 'destroy']);
    Route::put('/clothes/{id}',[ClothesController::class, 'update']);
});



