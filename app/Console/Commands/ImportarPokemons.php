<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;use App\Models\Pokemon;
use Illuminate\Support\Facades\Http;

class ImportarPokemons extends Command
{
    protected $signature = 'importar:pokemons';
    protected $description = 'Importa pokémons da PokeAPI para o banco de dados';

    public function handle()
    {
        $this->info("Importando pokémons...");
        $nextUrl = 'https://pokeapi.co/api/v2/pokemon?limit=100';
        $pokemonsData = [];
        $importados = 0;
    
        while ($nextUrl) {
            $response = Http::get($nextUrl);
    
            if (!$response->successful()) {
                $this->error('Erro ao acessar a PokeAPI');
                return 1;
            }
    
            $data = $response->json();
            $nextUrl = $data['next'];
    
            foreach ($data['results'] as $pokemonInfo) {
                $pokemonDetail = Http::get($pokemonInfo['url']);
    
                if (!$pokemonDetail->successful()) {
                    continue;
                }
    
                $detail = $pokemonDetail->json();
    
                if (!$detail || !isset($detail['name'])) {
                    continue;
                }
    
                $nome = $detail['name'];
    
                // Verifica se já existe no banco
                if (Pokemon::where('nome', $nome)->exists()) {
                    continue;
                }
    
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
    
                $this->line("➤ $nome importado.");
                $importados++;
    
                if (count($pokemonsData) >= 100) {
                    Pokemon::insert($pokemonsData);
                    $pokemonsData = [];
                }
            }
        }
    
        // Insere o que sobrou
        if (!empty($pokemonsData)) {
            Pokemon::insert($pokemonsData);
        }
    
        $this->info("✅ Total de pokémons importados: $importados");
    
        return 0;
    }
    
}