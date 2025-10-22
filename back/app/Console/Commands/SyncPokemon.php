<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Pokemon;

class SyncPokemon extends Command
{
    protected $signature = 'pokemon:sync {limit=151}';
    protected $description = 'Sincroniza Pokémon desde PokeAPI (detalle por ID)';

    
    public function handle(): int
    {
        $limit = (int)$this->argument('limit');

        $this->info("Sincronizando primeros {$limit} Pokémon desde PokeAPI...");

        for ($id = 1; $id <= $limit; $id++) {
            $url = "https://pokeapi.co/api/v2/pokemon/{$id}";
            $res = Http::timeout(20)->get($url);

            if ($res->failed()) {
                $this->warn("Falló id {$id}");
                continue;
            }

            $data = $res->json();

            $types = collect($data['types'] ?? [])
                ->map(fn($t) => $t['type']['name'] ?? null)
                ->filter()
                ->values()
                ->all();

            $abilities = collect($data['abilities'] ?? [])
                ->map(fn($a) => $a['ability']['name'] ?? null)
                ->filter()
                ->values()
                ->all();

            $stats = collect($data['stats'] ?? [])->map(function ($s) {
                return [
                    'name' => $s['stat']['name'] ?? null,
                    'base_stat' => $s['base_stat'] ?? null,
                ];
            })->all();

            Pokemon::updateOrCreate(
                ['external_id' => $data['id']],
                [
                    'name'            => $data['name'] ?? '',
                    'height'          => $data['height'] ?? null,
                    'weight'          => $data['weight'] ?? null,
                    'base_experience' => $data['base_experience'] ?? null,
                    'sprites'         => $data['sprites'] ?? null,
                    'types'           => $types,
                    'abilities'       => $abilities,
                    'stats'           => $stats,
                ]
            );

            $this->line("✔ {$data['id']} - {$data['name']}");
        }

        $this->info('Sincronización completa.');
        return self::SUCCESS;
    }
}
