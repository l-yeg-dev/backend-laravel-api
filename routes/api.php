<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PreferenceController;

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

Route::post('/auth/login', [AuthController::class, 'login']);
Route::post('/auth/register', [AuthController::class, 'register']);

Route::get('/auth/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::get('/preferences', [PreferenceController::class, 'getPreferences']);
Route::post('/preferences', [PreferenceController::class, 'setPreferences'])->middleware('auth:sanctum');

Route::get('/news', [ArticleController::class, 'search']);
Route::get('/news/{id}', [ArticleController::class, 'show']);
