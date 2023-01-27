<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\PessoaController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\OcorrenciaController;
use App\Http\Controllers\PdfController;

Route::get('/', [IndexController::class,'index']);

Route::get('registros/create', [RegistroController::class,'create']);
Route::post('registros', [RegistroController::class,'store']);
Route::get('registros/{registro}', [RegistroController::class,'show']);
Route::get('registros/{registro}/picture', [RegistroController::class, 'picture']);

Route::get('places/create', [PlaceController::class,'create']);
Route::post('places', [PlaceController::class,'store']);
Route::get('places', [PlaceController::class,'index']);

Route::patch('registros/{registro}/invalidate', [RegistroController::class, 'invalidate']);

Route::get('ocorrencias/create', [OcorrenciaController::class, 'create']);
Route::get('ocorrencias', [OcorrenciaController::class, 'index']);
Route::post('ocorrencias/', [OcorrenciaController::class, 'store']);
Route::post('ocorrencias/{ocorrencia}/solved', [OcorrenciaController::class, 'solved']);
Route::get('ocorrencias/solved', [OcorrenciaController::class, 'indexSolved']);
Route::get('ocorrencias/{ocorrencia}', [OcorrenciaController::class, 'show']);
Route::get('ocorrencias/{ocorrencia}/edit', [OcorrenciaController::class, 'edit']);
Route::patch('ocorrencias/{ocorrencia}/', [OcorrenciaController::class, 'update']);
Route::delete('ocorrencias/{ocorrencia}', [OcorrenciaController::class, 'destroy']);

Route::get('pessoas', [PessoaController::class,'index']);

Route::get('pessoas/{codpes}', [PessoaController::class,'show']);

Route::resource('grupos', GrupoController::class);

Route::get('folha/{codpes}', [PdfController::class,'folha']);

Route::get('justificar', [RegistroController::class,'justificar']);
Route::post('justificar', [RegistroController::class,'justificar_store']);
