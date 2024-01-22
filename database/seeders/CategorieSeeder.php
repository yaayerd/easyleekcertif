<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Creer ces catégories dans la base de données

        Categorie::factory()->create([
            'type' => 'Ndeki',
        ]);

        Categorie::factory()->create([
            'type' => 'Cuisine Locale',
        ]);
    
        Categorie::factory()->create([
            'type' => 'Fast Food',
        ]);

        Categorie::factory()->create([
            'type' => 'Ndiogonal',
        ]);

        Categorie::factory()->create([
            'type' => 'Patisserie',
        ]);
    }
}
