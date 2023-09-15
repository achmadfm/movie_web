<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MovieController::class, 'index']);
Route::get('/movies', [MovieController::class, 'movies']);
Route::get('/tvshow', [MovieController::class, 'tvshow']);
Route::get('/search', [MovieController::class, 'search']);
Route::get('/movie/{id}', [MovieController::class, 'movieDetails']);
Route::get('/tv/{id}', [MovieController::class, 'tvDetails']);
