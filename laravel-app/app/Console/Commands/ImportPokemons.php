<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;
use Exception;
use Log;

class ImportPokemons extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-pokemons';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Importar pokemons desde uma API externa';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $url = "https://pokeapi.co/api/v2/pokemon";
            $page = 1;
            $total = 0;
            $importTotal = 0;

            $this->info('Começo da importação de pokemons');

            while (!empty($url)) {
                $response = Http::timeout(10)
                ->accept('application/json')
                ->get($url);
                
                if($response->failed()) {
                    $this->error("Erro ao importar pagina $page.");
                    continue;
                }

                $this->info("\nImportando página $page");

                if ($page == 1) {
                    $total = $response['count'];
                }

                $url = $response['next'];
                $pokemons = [];

                foreach ($response['results'] as $pokemon) {
                    $this->info('Importando pokemon '. $pokemon['name']);
                    
                    $pokemonInfo = Http::timeout(10)
                    ->accept('application/json')
                    ->get($pokemon['url']);
                
                    if ($pokemonInfo->failed()) {
                        $this->error("Erro ao importar informações do pokemon: " . $pokemon['name']);
                        continue;
                    }

                    $pokemons[] = [
                        'nome' => $pokemonInfo['name'],
                        'tipo' => $pokemonInfo['types'][0]['type']['name'],
                        'altura' => $pokemonInfo['height'],
                        'peso' => $pokemonInfo['weight'],
                        'created_at' => now()
                    ];

                    $importTotal++;
                }

                // Adicionar pagina atual ao banco de dados
                Pokemon::insertOrIgnore($pokemons);

                $page++;
            }

            $this->info($importTotal . " de $total pokemons foram importados.");
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
            Log::error('Erro ao importar pokemons: ' . $errorMessage);
            $this->error('Erro durante a importação de pokemons: ' . $errorMessage);
        }
    }
}
