<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PokemonController extends Controller
{
    public function index()
{
    $pokemons = Pokemon::paginate(20); // com paginação
    return view('pokemon.index', compact('pokemons'));
}

    // Salvar um novo pokémon manualmente (POST)
    public function store(Request $request)
    {
        $pokemon = Pokemon::create($request->all());
        return response()->json($pokemon, 201);
    }

    // Importar pokémons da PokeAPI
    public function importPokemons()
    {

        // Aumenta o tempo de execução para 5 minutos
        set_time_limit(300);
        $nextUrl = 'https://pokeapi.co/api/v2/pokemon?limit=100';
        $pokemonsData = [];

        while ($nextUrl) {
            $response = Http::get($nextUrl);

            if (!$response->successful()) {
                return response()->json(['message' => 'Erro ao acessar a PokeAPI'], 500);
            }

            $data = $response->json();
            $nextUrl = $data['next'];

            foreach ($data['results'] as $pokemonInfo) {
                $pokemonDetail = Http::get($pokemonInfo['url']);

                if (!$pokemonDetail->successful()) {
                    continue;
                }

                $detail = $pokemonDetail->json();

                $nome = $detail['name'];
                $tipo = collect($detail['types'])->pluck('type.name')->implode(', ');
                $habilidades = collect($detail['abilities'])->pluck('ability.name')->implode(', ');
                $altura = $detail['height'];
                $peso = $detail['weight'];
                $imagem = $detail['sprites']['other']['official-artwork']['front_default'] ?? null;

                $pokemonsData[] = [
                    'nome' => $nome,
                    'tipo' => $tipo,
                    'habilidades' => $habilidades,
                    'altura' => $altura,
                    'peso' => $peso,
                    'imagem' => $imagem,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                // Quando tiver 100 acumulados, insere no banco
                if (count($pokemonsData) >= 100) {
                    Pokemon::insert($pokemonsData);
                    $pokemonsData = [];
                }
            }
        }

        // Inserir o restante
        if (!empty($pokemonsData)) {
            Pokemon::insert($pokemonsData);
        }

        return response()->json(['message' => 'Todos os Pokémons foram importados com sucesso!']);
    }

    private function extractIdFromUrl($url)
    {
        // Ex: https://pokeapi.co/api/v2/pokemon/1/ => pega o "1"
        return rtrim(substr($url, strrpos(rtrim($url, '/'), '/') + 1), '/');
    }

    public function show($id)
{
    $pokemon = Pokemon::find($id);

    if (!$pokemon) {
        abort(404, 'Pokémon não encontrado');
    }

    return view('pokemon.show', compact('pokemon')); // aqui estava 'pokemons.show'
}
    
    
    
}
