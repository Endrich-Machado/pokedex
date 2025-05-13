<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::middleware('api')->get('/pokemons', [PokemonController::class, 'index']);
Route::middleware('api')->post('/pokemons', [PokemonController::class, 'store']);
Route::post('/import-pokemons', [PokemonController::class, 'importPokemons']);



