<?php

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

//Aluno
Route::post('/aluno', [\App\Http\Controllers\AlunoController::class, 'store']);

//Materia
Route::post('/Materia', [\App\Http\Controllers\MateriaController::class, 'store']);
