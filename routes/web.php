<?php

use App\Http\Controllers\PokemonController;
use Illuminate\Support\Facades\Route;

// Rota para listar todos os pokémons (com paginação)
Route::get('/pokemons', [PokemonController::class, 'index']);

// Rota para mostrar um pokémon individual
Route::get('/pokemons/{id}', [PokemonController::class, 'show']);
