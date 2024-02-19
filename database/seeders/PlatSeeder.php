<?php

namespace Database\Seeders;

use App\Models\Plat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plat::create([
            'is_archived' => false,
            'menu_id' => 1, 
            'libelle' => 'Plat 1',
            'prix' => 600,
            'image' => 'chemin/vers/plat1.jpg',
            'descriptif' => 'Description du plat 1',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 1, 
            'libelle' => 'Plat 1 bis',
            'prix' => 600,
            'image' => 'chemin/vers/plat1bis.jpg',
            'descriptif' => 'Description du plat 1 bis',
        ]);

         Plat::create([
            'is_archived' => false,
            'menu_id' => 2, 
            'libelle' => 'Plat 2',
            'prix' => 800,
            'image' => 'chemin/vers/plat2.jpg',
            'descriptif' => 'Description du plat 2',
        ]);

         Plat::create([
            'is_archived' => false,
            'menu_id' => 2, 
            'libelle' => 'Plat 2 bis',
            'prix' => 800,
            'image' => 'chemin/vers/plat2bis.jpg',
            'descriptif' => 'Description du plat 2 bis',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 3, 
            'libelle' => 'Plat 3',
            'prix' => 900,
            'image' => 'chemin/vers/plat3.jpg',
            'descriptif' => 'Description du plat 3',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 3, 
            'libelle' => 'Plat 3 bis',
            'prix' => 900,
            'image' => 'chemin/vers/plat3bis.jpg',
            'descriptif' => 'Description du plat 3 bis',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 4, 
            'libelle' => 'Plat 4',
            'prix' => 1000,
            'image' => 'chemin/vers/plat4.jpg',
            'descriptif' => 'Description du plat 4',
        ]);

        Plat::create([
            'is_archived' => false,
            'menu_id' => 4, 
            'libelle' => 'Plat 4 bis',
            'prix' => 1000,
            'image' => 'chemin/vers/plat4bis.jpg',
            'descriptif' => 'Description du plat 4 bis',
        ]);

        
    }
}
