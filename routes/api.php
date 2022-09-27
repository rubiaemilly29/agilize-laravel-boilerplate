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
Route::post('/materia', [\App\Http\Controllers\MateriaController::class, 'store']);

//Pergunta
Route::post('/pergunta', [\App\Http\Controllers\PerguntasController::class, 'store']);

//Resposta
Route::post('/resposta', [\App\Http\Controllers\RespostasController::class, 'store']);

//Prova
Route::get('/prova', [\App\Http\Controllers\ProvaController::class, 'create']);
