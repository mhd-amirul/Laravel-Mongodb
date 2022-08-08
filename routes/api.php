<?php

use App\Http\Controllers\Auth\AuthentikasiController;
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

Route::post('register', [AuthentikasiController::class, 'resgiter']);
Route::post('login', [AuthentikasiController::class, 'login']);
Route::get('profil', [AuthentikasiController::class, 'profil'])->middleware('auth:sanctum');
