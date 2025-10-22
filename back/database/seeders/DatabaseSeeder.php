<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Este seeder ejecuta el comando personalizado llamado SyncPokemon que se encarga de sincronizar los datos de la API
        Artisan::call('pokemon:sync', ['limit' => 151]);
    }
}
