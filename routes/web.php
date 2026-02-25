<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HolaMundo;

Route::get('/', function () {
    return view('welcome');
});

//ruta - controlador - metodo
Route::get('hola', [HolaMundo::class, 'index']);