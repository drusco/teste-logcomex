<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::prefix('api')->group(function () {
    Route::get('/pokemon', [PokemonController::class, 'index']);
    Route::get('/pokemon/{id}', [PokemonController::class, 'show']);
});