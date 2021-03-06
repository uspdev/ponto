<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\IndexController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\MonitorController;

Route::get('/', [IndexController::class,'index']);

Route::get('registros/create', [RegistroController::class,'create']);
Route::post('registros', [RegistroController::class,'store']);
Route::get('registros/{registro}', [RegistroController::class,'show']);
Route::get('registros/{registro}/picture', [RegistroController::class, 'picture']);

Route::get('places/create', [PlaceController::class,'create']);
Route::post('places', [PlaceController::class,'store']);
Route::get('places', [PlaceController::class,'index']);

Route::get('monitores', [MonitorController::class,'index']);
Route::get('monitores/{monitor}', [MonitorController::class,'show']);