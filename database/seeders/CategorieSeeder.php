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
            'image' => 'chemin/vers/ndeki.jpg',

        ]);

        Categorie::factory()->create([
            'type' => 'Cuisine Locale', 
            'image' => 'chemin/vers/cuisinelocale.jpg',

        ]);
    
        Categorie::factory()->create([
            'type' => 'Fast Food', 
            'image' => 'chemin/vers/fastfood.jpg',

        ]);

        Categorie::factory()->create([
            'type' => 'Ndiogonal', 
            'image' => 'chemin/vers/ndiogonal.jpg',

        ]);

        Categorie::factory()->create([
            'type' => 'Tangana', 
            'image' => 'chemin/vers/tangana.jpg',

        ]);

        Categorie::factory()->create([
            'type' => 'Dibiterie', 
            'image' => 'chemin/vers/dibiterie.jpg',

        ]);

        
    }
}
