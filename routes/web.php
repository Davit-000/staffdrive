<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\ProjectsController;

Auth::routes();

Route::get('/', function () {
  return view('welcome');
});

Route::resource('/clients', class_basename(ClientsController::class))
  ->only('index', 'store', 'update', 'destroy');

Route::resource('/clients/{client}/projects', class_basename(ProjectsController::class))
  ->only( 'store', 'update', 'destroy');
