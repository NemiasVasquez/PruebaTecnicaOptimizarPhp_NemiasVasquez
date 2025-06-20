<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\datos_controller;

Route::get('prueba', [datos_controller::class, 'prueba']);

