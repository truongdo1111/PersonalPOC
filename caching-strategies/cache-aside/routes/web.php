<?php

use App\Http\Controllers\ExampleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ExampleController::class, 'withCache']);
Route::get('/without-cache', [ExampleController::class, 'withoutCache']);
