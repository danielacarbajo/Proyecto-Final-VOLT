<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Ejecuta todos los seeders de la aplicación.
     */
    public function run(): void
    {
        $this->call([
            RolesSeeder::class,
            // Más seeders aquí en el futuro si los necesitamos
        ]);
    }
}
